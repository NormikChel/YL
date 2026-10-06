#!/usr/bin/env php
<?php
declare(strict_types=1);
error_reporting(E_ALL);
mb_internal_encoding('UTF-8');

/* ==================== СИМВОЛЫ ==================== */
final class Sym {
    public static array $m = [
        'comment'=>'~','declare'=>'¤','fn'=>'§','lambda'=>'λ','print'=>'»',
        'open'=>'⟦','close'=>'⟧','if'=>'?','else'=>'¿','while'=>'@','for'=>'#',
        'return'=>'^','true'=>'☑','false'=>'☐','null'=>'∅',
        'try'=>'‼','catch'=>'⁇','finally'=>'⌦','import'=>'⊕',
        'break'=>'⊘','continue'=>'↻','assert'=>'≡','dict_o'=>'⟪','dict_c'=>'⟫',
        'class'=>'‡','method'=>'⋔','new'=>'⇢','yield'=>'↤','foreach'=>'⇶',
        'inherit'=>'†','async'=>'⚡','await'=>'⏸',
    ];
    public static function load(?string $p): void {
        if ($p && is_file($p)) {
            $c = json_decode((string)file_get_contents($p), true);
            if (is_array($c)) self::$m = array_merge(self::$m, $c);
        }
    }
    public static function all(): array { return array_values(self::$m); }
}

final class Env {
    public static bool $sandbox = false;
    public static int $maxSteps = 50_000_000;
    public static int $steps = 0;
    public static array $moduleCache = [];
}

class YLException extends RuntimeException {
    public function __construct(string $msg, public int $line = 0) {
        parent::__construct($line ? "[строка $line] $msg" : $msg);
    }
}
class ReturnException extends Exception { public function __construct(public mixed $value) { parent::__construct(''); } }
class BreakException extends Exception {}
class ContinueException extends Exception {}

final class Scope {
    public array $vars = [];
    public ?Scope $parent;
    public function __construct(?Scope $parent = null) { $this->parent = $parent; }
    public function has(string $n): bool {
        return array_key_exists($n, $this->vars) || ($this->parent && $this->parent->has($n));
    }
    public function get(string $n): mixed {
        if (array_key_exists($n, $this->vars)) return $this->vars[$n];
        if ($this->parent) return $this->parent->get($n);
        throw new RuntimeException("Неизвестная переменная: $n");
    }
    public function set(string $n, mixed $v): void {
        if (array_key_exists($n, $this->vars)) { $this->vars[$n] = $v; return; }
        if ($this->parent && $this->parent->has($n)) { $this->parent->set($n, $v); return; }
        $this->vars[$n] = $v;
    }
    public function define(string $n, mixed $v): void { $this->vars[$n] = $v; }
}

final class YLFunction {
    public function __construct(
        public array $params, public array $paramTypes, public array $body,
        public Scope $closure, public ?string $retType = null, public ?string $name = null,
        public bool $isGenerator = false, public bool $isAsync = false,
    ) {}
}
final class YLModule { public function __construct(public array $vars = []) {} }
final class YLClass {
    public function __construct(public string $name, public ?string $parent, public array $methods) {}
}
final class YLInstance {
    public array $fields = [];
    public function __construct(public YLClass $class) {}
}

final class YLGenerator {
    private ?Fiber $fiber = null;
    public bool $finished = false;
    public mixed $current = null;
    public function __construct(private YLFunction $fn, private array $args, private Interpreter $interp) {}
    public function next(): bool {
        if ($this->finished) return false;
        $value = null;
        if ($this->fiber === null) {
            $fn = $this->fn; $args = $this->args; $interp = $this->interp;
            $this->fiber = new Fiber(function() use ($fn, $args, $interp) {
                $interp->callUser($fn, $args);
            });
            $value = $this->fiber->start();
        } elseif ($this->fiber->isSuspended()) {
            $value = $this->fiber->resume();
        } else {
            $this->finished = true;
            return false;
        }
        if ($this->fiber->isTerminated()) { $this->finished = true; return false; }
        $this->current = $value;
        return true;
    }
}

final class AsyncTask {
    public mixed $result = null;
    public bool $done = false;
    public function __construct(public YLFunction $fn, public array $args, public Interpreter $interp) {}
    public function run(): mixed {
        if ($this->done) return $this->result;
        $this->result = $this->interp->callUser($this->fn, $this->args);
        $this->done = true;
        return $this->result;
    }
}

/* ==================== ЛЕКСЕР ==================== */
final class Lexer {
    private int $pos = 0, $len, $line = 1;
    private array $tokens = [];
    public function __construct(private string $src) { $this->len = mb_strlen($src, 'UTF-8'); }
    private function peek(int $o = 0): string { return mb_substr($this->src, $this->pos + $o, 1, 'UTF-8'); }

    public function tokenize(): array {
        $syms = Sym::all();
        while ($this->pos < $this->len) {
            $c = $this->peek();
            if ($c === "\n") { $this->line++; $this->pos++; continue; }
            if (preg_match('/\s/u', $c) || $c === ';') { $this->pos++; continue; }
            if ($c === Sym::$m['comment']) {
                while ($this->pos < $this->len && $this->peek() !== "\n") $this->pos++;
                continue;
            }
            $ln = $this->line;
            if (in_array($c, $syms, true)) {
                $this->tokens[] = ['t'=>'SYM','v'=>$c,'line'=>$ln]; $this->pos++; continue;
            }
            if ($c === '"' || $c === "'") { $this->readString($c, $ln); continue; }
            if (preg_match('/\d/', $c) || ($c === '.' && preg_match('/\d/', $this->peek(1)))) {
                $s = '';
                while ($this->pos < $this->len &&
                       (preg_match('/\d/', $this->peek()) || $this->peek() === '.')) {
                    $s .= $this->peek(); $this->pos++;
                }
                $this->tokens[] = ['t'=>'NUMBER','v'=>str_contains($s,'.')?(float)$s:(int)$s,'line'=>$ln];
                continue;
            }
            if (preg_match('/[\p{L}\p{So}_]/u', $c)) {
                $s = '';
                while ($this->pos < $this->len && preg_match('/[\p{L}\p{N}_]/u', $this->peek())) {
                    $s .= $this->peek(); $this->pos++;
                }
                $this->tokens[] = ['t'=>'IDENT','v'=>$s,'line'=>$ln]; continue;
            }
            $two = $this->peek() . $this->peek(1);
            if (in_array($two, ['==','!=','<=','>=','&&','||','..'], true)) {
                $this->tokens[] = ['t'=>'OP','v'=>$two,'line'=>$ln]; $this->pos += 2; continue;
            }
            if (str_contains('+-*/%<>=!.,()[]@#^:', $c)) {
                $this->tokens[] = ['t'=>'OP','v'=>$c,'line'=>$ln]; $this->pos++; continue;
            }
            throw new YLException("Неизвестный символ: '$c'", $ln);
        }
        $this->tokens[] = ['t'=>'EOF','v'=>null,'line'=>$this->line];
        return $this->tokens;
    }

    private function readString(string $q, int $ln): void {
        $this->pos++;
        $s = '';
        while ($this->pos < $this->len && $this->peek() !== $q) {
            $ch = $this->peek();
            if ($ch === '\\') {
                $this->pos++;
                $s .= match($this->peek()) {
                    'n'=>"\n",'t'=>"\t",'r'=>"\r",'\\'=>'\\','"'=>'"',"'"=>"'",
                    default=>$this->peek(),
                };
                $this->pos++;
            } else {
                if ($ch === "\n") $this->line++;
                $s .= $ch; $this->pos++;
            }
        }
        if ($this->pos >= $this->len) throw new YLException('Незакрытая строка', $ln);
        $this->pos++;
        $this->tokens[] = ['t'=>'STRING','v'=>$s,'line'=>$ln];
    }
}

/* ==================== ПАРСЕР ==================== */
final class Parser {
    private int $pos = 0;
    public function __construct(private array $tokens) {}
    private function peek(int $o = 0): array { return $this->tokens[$this->pos + $o] ?? ['t'=>'EOF','v'=>null,'line'=>0]; }
    private function consume(): array { return $this->tokens[$this->pos++]; }
    private function line(): int { return $this->peek()['line'] ?? 0; }
    private function match(string $t, ?string $v = null): bool {
        $x = $this->peek();
        return $x['t'] === $t && ($v === null || $x['v'] === $v);
    }
    private function isSym(string $k): bool { return $this->match('SYM', Sym::$m[$k]); }
    private function expect(string $t, ?string $v = null): array {
        if (!$this->match($t, $v)) {
            $x = $this->peek();
            throw new YLException("Ожидалось $t" . ($v!==null?" '$v'":'') . ", получено {$x['t']} '{$x['v']}'", $x['line'] ?? 0);
        }
        return $this->consume();
    }
    private function node(array $n): array { $n['line'] = $n['line'] ?? $this->line(); return $n; }

    public function parse(): array {
        $body = [];
        while (!$this->match('EOF')) $body[] = $this->statement();
        return $this->node(['type'=>'Program','body'=>$body]);
    }

    private function statement(): array {
        if ($this->isSym('async'))     return $this->asyncFnStmt();
        if ($this->isSym('declare'))   return $this->declStmt();
        if ($this->isSym('fn'))        return $this->fnStmt(false);
        if ($this->isSym('class'))     return $this->classStmt();
        if ($this->isSym('print'))     return $this->printStmt();
        if ($this->isSym('return'))    return $this->returnStmt();
        if ($this->isSym('yield'))     return $this->yieldStmt();
        if ($this->isSym('if'))        return $this->ifStmt();
        if ($this->isSym('while'))     return $this->whileStmt();
        if ($this->isSym('for'))       return $this->forStmt();
        if ($this->isSym('foreach'))   return $this->foreachStmt();
        if ($this->isSym('import'))    return $this->importStmt();
        if ($this->isSym('try'))       return $this->tryStmt();
        if ($this->isSym('break'))     { $this->consume(); return $this->node(['type'=>'Break']); }
        if ($this->isSym('continue'))  { $this->consume(); return $this->node(['type'=>'Continue']); }
        if ($this->isSym('assert'))    return $this->assertStmt();

        $expr = $this->expression();
        if ($this->match('OP', '=')) {
            $this->consume();
            $value = $this->expression();
            switch ($expr['type']) {
                case 'Ident': return $this->node(['type'=>'Assign','name'=>$expr['name'],'value'=>$value]);
                case 'MemberAccess': return $this->node(['type'=>'SetMember','target'=>$expr['target'],'name'=>$expr['name'],'value'=>$value]);
                case 'Index': return $this->node(['type'=>'SetIndex','target'=>$expr['target'],'index'=>$expr['index'],'value'=>$value]);
                default: throw new YLException('Неверная цель присваивания', $expr['line'] ?? 0);
            }
        }
        return $this->node(['type'=>'ExprStmt','expr'=>$expr]);
    }

    private function asyncFnStmt(): array {
        $this->consume();
        if (!$this->isSym('fn')) throw new YLException('После ⚡ ожидался §', $this->line());
        return $this->fnStmt(true);
    }

    private function fnStmt(bool $isAsync): array {
        $this->consume();
        $name = $this->expect('IDENT')['v'];
        [$params, $paramTypes] = $this->paramList();
        $retType = null;
        if ($this->match('OP', ':')) { $this->consume(); $retType = $this->expect('IDENT')['v']; }
        $body = $this->block()['body'];
        return $this->node([
            'type'=>'FuncDef','name'=>$name,'params'=>$params,'paramTypes'=>$paramTypes,
            'retType'=>$retType,'body'=>$body,'isGenerator'=>$this->containsYield($body),'isAsync'=>$isAsync,
        ]);
    }

    private function containsYield(array $stmts): bool {
        foreach ($stmts as $s) {
            if (($s['type'] ?? '') === 'Yield') return true;
            foreach (['body','then','else','catchBody','finally'] as $k) {
                if (isset($s[$k]) && is_array($s[$k]) && $this->containsYield($s[$k])) return true;
            }
        }
        return false;
    }

    private function classStmt(): array {
        $this->consume();
        $name = $this->expect('IDENT')['v'];
        $parent = null;
        if ($this->isSym('inherit')) { $this->consume(); $parent = $this->expect('IDENT')['v']; }
        $this->expect('SYM', Sym::$m['open']);
        $methods = [];
        while (!$this->isSym('close')) {
            if ($this->match('EOF')) throw new YLException('Незакрытое тело класса', $this->line());
            if (!$this->isSym('method')) throw new YLException("В классе ожидался ⋔", $this->line());
            $this->consume();
            $mName = $this->expect('IDENT')['v'];
            [$mParams, $mTypes] = $this->paramList();
            $mRetType = null;
            if ($this->match('OP', ':')) { $this->consume(); $mRetType = $this->expect('IDENT')['v']; }
            $mBody = $this->block()['body'];
            $methods[$mName] = [
                'params'=>$mParams,'paramTypes'=>$mTypes,'retType'=>$mRetType,
                'body'=>$mBody,'isGenerator'=>$this->containsYield($mBody),
            ];
        }
        $this->consume();
        return $this->node(['type'=>'ClassDef','name'=>$name,'parent'=>$parent,'methods'=>$methods]);
    }

    private function declStmt(): array {
        $this->consume();
        if ($this->match('OP', '[')) {
            $this->consume();
            $names = [];
            if (!$this->match('OP', ']')) {
                $names[] = $this->expect('IDENT')['v'];
                while ($this->match('OP', ',')) { $this->consume(); $names[] = $this->expect('IDENT')['v']; }
            }
            $this->expect('OP', ']'); $this->expect('OP', '=');
            return $this->node(['type'=>'DeclDestruct','mode'=>'array','names'=>$names,'value'=>$this->expression()]);
        }
        if ($this->isSym('dict_o')) {
            $this->consume();
            $names = [];
            if (!$this->isSym('dict_c')) {
                $names[] = $this->expect('STRING')['v'];
                while ($this->match('OP', ',')) { $this->consume(); $names[] = $this->expect('STRING')['v']; }
            }
            $this->expect('SYM', Sym::$m['dict_c']); $this->expect('OP', '=');
            return $this->node(['type'=>'DeclDestruct','mode'=>'dict','names'=>$names,'value'=>$this->expression()]);
        }
        $name = $this->expect('IDENT')['v'];
        $varType = null;
        if ($this->match('OP', ':')) { $this->consume(); $varType = $this->expect('IDENT')['v']; }
        $this->expect('OP', '=');
        $value = $this->expression();
        return $this->node(['type'=>'Decl','name'=>$name,'varType'=>$varType,'value'=>$value]);
    }

    private function paramList(): array {
        $this->expect('OP', '(');
        $params = []; $types = [];
        if (!$this->match('OP', ')')) {
            while (true) {
                $params[] = $this->expect('IDENT')['v'];
                $ty = null;
                if ($this->match('OP', ':')) { $this->consume(); $ty = $this->expect('IDENT')['v']; }
                $types[] = $ty;
                if ($this->match('OP', ',')) { $this->consume(); continue; }
                break;
            }
        }
        $this->expect('OP', ')');
        return [$params, $types];
    }

    private function printStmt(): array {
        $this->consume();
        $v = [$this->expression()];
        while ($this->match('OP', ',')) { $this->consume(); $v[] = $this->expression(); }
        return $this->node(['type'=>'Print','values'=>$v]);
    }
    private function returnStmt(): array {
        $this->consume();
        if ($this->isSym('close') || $this->match('EOF')) return $this->node(['type'=>'Return','value'=>null]);
        return $this->node(['type'=>'Return','value'=>$this->expression()]);
    }
    private function yieldStmt(): array {
        $this->consume();
        return $this->node(['type'=>'Yield','value'=>$this->expression()]);
    }
    private function ifStmt(): array {
        $this->consume();
        $cond = $this->expression();
        $then = $this->block()['body'];
        $else = null;
        if ($this->isSym('else')) { $this->consume(); $else = $this->block()['body']; }
        return $this->node(['type'=>'If','cond'=>$cond,'then'=>$then,'else'=>$else]);
    }
    private function whileStmt(): array {
        $this->consume();
        $cond = $this->expression();
        return $this->node(['type'=>'While','cond'=>$cond,'body'=>$this->block()['body']]);
    }
    private function forStmt(): array {
        $this->consume();
        $var = $this->expect('IDENT')['v'];
        $this->expect('OP', '=');
        $from = $this->expression();
        $this->expect('OP', '..');
        $to = $this->expression();
        return $this->node(['type'=>'For','var'=>$var,'from'=>$from,'to'=>$to,'body'=>$this->block()['body']]);
    }
    private function foreachStmt(): array {
        $this->consume();
        $var = $this->expect('IDENT')['v'];
        $this->expect('OP', '=');
        $iter = $this->expression();
        return $this->node(['type'=>'Foreach','var'=>$var,'iter'=>$iter,'body'=>$this->block()['body']]);
    }
    private function importStmt(): array {
        $this->consume();
        $path = $this->expect('STRING')['v'];
        $alias = null;
        if ($this->match('IDENT', 'as')) { $this->consume(); $alias = $this->expect('IDENT')['v']; }
        return $this->node(['type'=>'Import','path'=>$path,'alias'=>$alias]);
    }
    private function tryStmt(): array {
        $this->consume();
        $body = $this->block()['body'];
        $catchVar = null; $catchBody = null; $finallyBody = null;
        if ($this->isSym('catch')) {
            $this->consume();
            $catchVar = $this->match('IDENT') ? $this->consume()['v'] : 'ошибка';
            $catchBody = $this->block()['body'];
        }
        if ($this->isSym('finally')) { $this->consume(); $finallyBody = $this->block()['body']; }
        return $this->node(['type'=>'Try','body'=>$body,'catchVar'=>$catchVar,'catchBody'=>$catchBody,'finally'=>$finallyBody]);
    }
    private function assertStmt(): array {
        $this->consume();
        $cond = $this->expression();
        $msg = null;
        if ($this->match('OP', ',')) { $this->consume(); $msg = $this->expression(); }
        return $this->node(['type'=>'Assert','cond'=>$cond,'msg'=>$msg]);
    }
    private function block(): array {
        $this->expect('SYM', Sym::$m['open']);
        $body = [];
        while (!$this->isSym('close')) {
            if ($this->match('EOF')) throw new YLException('Незакрытый блок ⟦', $this->line());
            $body[] = $this->statement();
        }
        $this->consume();
        return $this->node(['type'=>'Block','body'=>$body]);
    }

    private function expression(): array { return $this->orExpr(); }
    private function orExpr(): array {
        $l = $this->andExpr();
        while ($this->match('OP', '||')) {
            $this->consume();
            $l = $this->node(['type'=>'BinOp','op'=>'||','left'=>$l,'right'=>$this->andExpr()]);
        }
        return $l;
    }
    private function andExpr(): array {
        $l = $this->equality();
        while ($this->match('OP', '&&')) {
            $this->consume();
            $l = $this->node(['type'=>'BinOp','op'=>'&&','left'=>$l,'right'=>$this->equality()]);
        }
        return $l;
    }
    private function equality(): array {
        $l = $this->comparison();
        while ($this->match('OP','==') || $this->match('OP','!=')) {
            $op = $this->consume()['v'];
            $l = $this->node(['type'=>'BinOp','op'=>$op,'left'=>$l,'right'=>$this->comparison()]);
        }
        return $l;
    }
    private function comparison(): array {
        $l = $this->term();
        while (in_array($this->peek()['v'] ?? null, ['<','>','<=','>='], true)) {
            $op = $this->consume()['v'];
            $l = $this->node(['type'=>'BinOp','op'=>$op,'left'=>$l,'right'=>$this->term()]);
        }
        return $l;
    }
    private function term(): array {
        $l = $this->factor();
        while ($this->match('OP','+') || $this->match('OP','-')) {
            $op = $this->consume()['v'];
            $l = $this->node(['type'=>'BinOp','op'=>$op,'left'=>$l,'right'=>$this->factor()]);
        }
        return $l;
    }
    private function factor(): array {
        $l = $this->unary();
        while (in_array($this->peek()['v'] ?? null, ['*','/','%'], true)) {
            $op = $this->consume()['v'];
            $l = $this->node(['type'=>'BinOp','op'=>$op,'left'=>$l,'right'=>$this->unary()]);
        }
        return $l;
    }
    private function unary(): array {
        if ($this->isSym('await')) {
            $this->consume();
            return $this->node(['type'=>'Await','expr'=>$this->unary()]);
        }
        if ($this->match('OP','!') || $this->match('OP','-')) {
            $op = $this->consume()['v'];
            return $this->node(['type'=>'UnaryOp','op'=>$op,'expr'=>$this->unary()]);
        }
        return $this->postfix();
    }
    private function postfix(): array {
        $e = $this->primary();
        while (true) {
            if ($this->match('OP','(')) {
                $this->consume();
                $args = [];
                if (!$this->match('OP',')')) {
                    $args[] = $this->expression();
                    while ($this->match('OP',',')) { $this->consume(); $args[] = $this->expression(); }
                }
                $this->expect('OP',')');
                $e = $this->node(['type'=>'Call','callee'=>$e,'args'=>$args]);
            } elseif ($this->match('OP','[')) {
                $this->consume();
                $idx = $this->expression();
                $this->expect('OP',']');
                $e = $this->node(['type'=>'Index','target'=>$e,'index'=>$idx]);
            } elseif ($this->match('OP','.')) {
                $this->consume();
                $name = $this->expect('IDENT')['v'];
                if ($this->match('OP','(')) {
                    $this->consume();
                    $args = [];
                    if (!$this->match('OP',')')) {
                        $args[] = $this->expression();
                        while ($this->match('OP',',')) { $this->consume(); $args[] = $this->expression(); }
                    }
                    $this->expect('OP',')');
                    $e = $this->node(['type'=>'MethodCall','target'=>$e,'method'=>$name,'args'=>$args]);
                } else {
                    $e = $this->node(['type'=>'MemberAccess','target'=>$e,'name'=>$name]);
                }
            } else break;
        }
        return $e;
    }
    private function primary(): array {
        $t = $this->peek();
        if ($t['t'] === 'NUMBER') { $this->consume(); return $this->node(['type'=>'Number','value'=>$t['v']]); }
        if ($t['t'] === 'STRING') { $this->consume(); return $this->node(['type'=>'String','value'=>$t['v']]); }
        if ($t['t'] === 'IDENT')  { $this->consume(); return $this->node(['type'=>'Ident','name'=>$t['v']]); }
        if ($t['t'] === 'SYM') {
            if ($t['v'] === Sym::$m['true'])   { $this->consume(); return $this->node(['type'=>'Bool','value'=>true]); }
            if ($t['v'] === Sym::$m['false'])  { $this->consume(); return $this->node(['type'=>'Bool','value'=>false]); }
            if ($t['v'] === Sym::$m['null'])   { $this->consume(); return $this->node(['type'=>'Null']); }
            if ($t['v'] === Sym::$m['lambda']) { $this->consume(); return $this->lambdaExpr(); }
            if ($t['v'] === Sym::$m['dict_o']) { return $this->dictExpr(); }
            if ($t['v'] === Sym::$m['new'])    { $this->consume(); return $this->newExpr(); }
        }
        if ($this->match('OP','(')) {
            $this->consume();
            $e = $this->expression();
            $this->expect('OP',')');
            return $e;
        }
        if ($this->match('OP','[')) {
            $this->consume();
            $items = [];
            if (!$this->match('OP',']')) {
                $items[] = $this->expression();
                while ($this->match('OP',',')) { $this->consume(); $items[] = $this->expression(); }
            }
            $this->expect('OP',']');
            return $this->node(['type'=>'Array','items'=>$items]);
        }
        throw new YLException("Неожиданный токен: {$t['t']} '{$t['v']}'", $t['line'] ?? 0);
    }
    private function lambdaExpr(): array {
        [$params, $paramTypes] = $this->paramList();
        $retType = null;
        if ($this->match('OP', ':')) { $this->consume(); $retType = $this->expect('IDENT')['v']; }
        $body = $this->block()['body'];
        return $this->node([
            'type'=>'Lambda','params'=>$params,'paramTypes'=>$paramTypes,'retType'=>$retType,
            'body'=>$body,'isGenerator'=>$this->containsYield($body),
        ]);
    }
    private function dictExpr(): array {
        $this->expect('SYM', Sym::$m['dict_o']);
        $pairs = [];
        if (!$this->isSym('dict_c')) {
            while (true) {
                $k = $this->expect('STRING')['v'];
                $this->expect('OP', ':');
                $pairs[$k] = $this->expression();
                if ($this->match('OP',',')) { $this->consume(); continue; }
                break;
            }
        }
        $this->expect('SYM', Sym::$m['dict_c']);
        return $this->node(['type'=>'Dict','pairs'=>$pairs]);
    }
    private function newExpr(): array {
        $cls = $this->expect('IDENT')['v'];
        $this->expect('OP', '(');
        $args = [];
        if (!$this->match('OP', ')')) {
            $args[] = $this->expression();
            while ($this->match('OP', ',')) { $this->consume(); $args[] = $this->expression(); }
        }
        $this->expect('OP', ')');
        return $this->node(['type'=>'New','class'=>$cls,'args'=>$args]);
    }
}

/* ==================== ИНТЕРПРЕТАТОР ==================== */
final class Interpreter {
    public Scope $global;
    public function __construct(?Scope $parent = null) { $this->global = new Scope($parent); }

    private function tick(): void {
        if (++Env::$steps > Env::$maxSteps) throw new RuntimeException('Превышен лимит шагов');
    }

    public function runProgram(array $prog, ?Scope $scope = null): void {
        $this->execBlock($prog['body'], $scope ?? $this->global);
    }

    private function execBlock(array $stmts, Scope $s): void {
        foreach ($stmts as $st) $this->exec($st, $s);
    }

    private function exec(array $n, Scope $s): void {
        $this->tick();
        try {
            $this->execInner($n, $s);
        } catch (YLException|ReturnException|BreakException|ContinueException $e) {
            throw $e;
        } catch (FiberError $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new YLException($e->getMessage(), $n['line'] ?? 0);
        }
    }

    private function execInner(array $n, Scope $s): void {
        switch ($n['type']) {
            case 'Decl':
                $val = $this->eval($n['value'], $s);
                if (!empty($n['varType'])) $this->typeCheck($val, $n['varType'], "переменная {$n['name']}");
                $s->define($n['name'], $val);
                break;
            case 'DeclDestruct':
                $val = $this->eval($n['value'], $s);
                foreach ($n['names'] as $i => $nm) {
                    $v = $n['mode'] === 'array' ? ($val[$i] ?? null) : ($val[$nm] ?? null);
                    $s->define($nm, $v);
                }
                break;
            case 'Assign': $s->set($n['name'], $this->eval($n['value'], $s)); break;
            case 'SetMember':
                $t = $this->eval($n['target'], $s);
                $v = $this->eval($n['value'], $s);
                if ($t instanceof YLInstance) $t->fields[$n['name']] = $v;
                elseif ($t instanceof YLModule) $t->vars[$n['name']] = $v;
                else throw new RuntimeException('Нельзя присвоить поле у ' . $this->typeName($t));
                break;
            case 'SetIndex':
                $t = $this->eval($n['target'], $s);
                $i = $this->eval($n['index'], $s);
                $v = $this->eval($n['value'], $s);
                if (!is_array($t)) throw new RuntimeException('Индексная запись только для массивов');
                $t[$i] = $v;
                if ($n['target']['type'] === 'Ident') $s->set($n['target']['name'], $t);
                break;
            case 'FuncDef':
                $s->define($n['name'], new YLFunction(
                    $n['params'], $n['paramTypes'], $n['body'], $s,
                    $n['retType'], $n['name'], $n['isGenerator'], $n['isAsync']
                ));
                break;
            case 'ClassDef':
                $s->define($n['name'], new YLClass($n['name'], $n['parent'], $n['methods']));
                break;
            case 'Print':
                echo implode(' ', array_map(fn($e) => $this->toStr($this->eval($e, $s)), $n['values'])) . "\n";
                break;
            case 'ExprStmt': $this->eval($n['expr'], $s); break;
            case 'Assert':
                if (!$this->truthy($this->eval($n['cond'], $s))) {
                    $msg = $n['msg'] ? $this->toStr($this->eval($n['msg'], $s)) : 'assertion failed';
                    throw new RuntimeException("Assert: $msg");
                }
                break;
            case 'If':
                if ($this->truthy($this->eval($n['cond'], $s))) $this->execBlock($n['then'], new Scope($s));
                elseif ($n['else']) $this->execBlock($n['else'], new Scope($s));
                break;
            case 'While':
                while ($this->truthy($this->eval($n['cond'], $s))) {
                    try { $this->execBlock($n['body'], new Scope($s)); }
                    catch (BreakException) { break; }
                    catch (ContinueException) { continue; }
                }
                break;
            case 'For':
                $a = (int)$this->eval($n['from'], $s);
                $b = (int)$this->eval($n['to'], $s);
                for ($i = $a; $i < $b; $i++) {
                    $inner = new Scope($s);
                    $inner->define($n['var'], $i);
                    try { $this->execBlock($n['body'], $inner); }
                    catch (BreakException) { break; }
                    catch (ContinueException) { continue; }
                }
                break;
            case 'Foreach':
                $iter = $this->eval($n['iter'], $s);
                if ($iter instanceof YLGenerator) {
                    while ($iter->next()) {
                        $inner = new Scope($s);
                        $inner->define($n['var'], $iter->current);
                        try { $this->execBlock($n['body'], $inner); }
                        catch (BreakException) { break; }
                        catch (ContinueException) { continue; }
                    }
                } elseif (is_array($iter)) {
                    foreach ($iter as $v) {
                        $inner = new Scope($s);
                        $inner->define($n['var'], $v);
                        try { $this->execBlock($n['body'], $inner); }
                        catch (BreakException) { break; }
                        catch (ContinueException) { continue; }
                    }
                } else {
                    throw new RuntimeException('⇶ ожидает массив или генератор, получено ' . $this->typeName($iter));
                }
                break;
            case 'Return':
                throw new ReturnException($n['value'] ? $this->eval($n['value'], $s) : null);
            case 'Yield':
                $v = $this->eval($n['value'], $s);
                if (Fiber::getCurrent() === null) throw new RuntimeException('↤ вне генератора');
                Fiber::suspend($v);
                break;
            case 'Break':    throw new BreakException();
            case 'Continue': throw new ContinueException();
            case 'Import':   $this->doImport($n, $s); break;
            case 'Try':
                try {
                    $this->execBlock($n['body'], new Scope($s));
                } catch (ReturnException|BreakException|ContinueException $e) {
                    throw $e;
                } catch (\Throwable $e) {
                    if ($n['catchBody'] !== null) {
                        $cs = new Scope($s);
                        $cs->define($n['catchVar'], $e->getMessage());
                        $this->execBlock($n['catchBody'], $cs);
                    } else throw $e;
                } finally {
                    if ($n['finally'] !== null) $this->execBlock($n['finally'], new Scope($s));
                }
                break;
            default:
                throw new RuntimeException("Неизвестная инструкция: {$n['type']}");
        }
    }

    private function eval(array $n, Scope $s): mixed {
        $this->tick();
        try {
            return $this->evalInner($n, $s);
        } catch (YLException|ReturnException|BreakException|ContinueException $e) {
            throw $e;
        } catch (FiberError $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new YLException($e->getMessage(), $n['line'] ?? 0);
        }
    }

    private function evalInner(array $n, Scope $s): mixed {
        switch ($n['type']) {
            case 'Number': return $n['value'];
            case 'String': return $n['value'];
            case 'Bool':   return $n['value'];
            case 'Null':   return null;
            case 'Ident':  return $s->get($n['name']);
            case 'Array':  return array_map(fn($i) => $this->eval($i, $s), $n['items']);
            case 'Dict':
                $d = [];
                foreach ($n['pairs'] as $k => $v) $d[$k] = $this->eval($v, $s);
                return $d;
            case 'Lambda':
                return new YLFunction($n['params'], $n['paramTypes'], $n['body'], $s,
                    $n['retType'], null, $n['isGenerator']);
            case 'BinOp':
                return $this->binop($n['op'], $this->eval($n['left'], $s), $this->eval($n['right'], $s));
            case 'UnaryOp':
                $v = $this->eval($n['expr'], $s);
                return $n['op'] === '!' ? !$this->truthy($v) : -$v;
            case 'Await':
                $v = $this->eval($n['expr'], $s);
                if ($v instanceof AsyncTask) return $v->run();
                return $v;
            case 'Call': return $this->doCall($n, $s);
            case 'MethodCall': return $this->doMethodCall($n, $s);
            case 'MemberAccess':
                $t = $this->eval($n['target'], $s);
                if ($t instanceof YLModule) {
                    if (!array_key_exists($n['name'], $t->vars))
                        throw new RuntimeException("Модуль не содержит '{$n['name']}'");
                    return $t->vars[$n['name']];
                }
                if ($t instanceof YLInstance) {
                    if (array_key_exists($n['name'], $t->fields)) return $t->fields[$n['name']];
                    throw new RuntimeException("У объекта нет поля '{$n['name']}'");
                }
                throw new RuntimeException("Нельзя обратиться к члену у " . $this->typeName($t));
            case 'Index':
                $t = $this->eval($n['target'], $s);
                $i = $this->eval($n['index'], $s);
                if (is_array($t)) return $t[$i] ?? null;
                if (is_string($t)) return mb_substr($t, (int)$i, 1, 'UTF-8');
                return null;
            case 'New': return $this->doNew($n, $s);
        }
        throw new RuntimeException("Неизвестное выражение: {$n['type']}");
    }

    private function doNew(array $n, Scope $s): YLInstance {
        $cls = $s->get($n['class']);
        if (!$cls instanceof YLClass) throw new RuntimeException("'{$n['class']}' не класс");
        $inst = new YLInstance($cls);
        $args = array_map(fn($a) => $this->eval($a, $s), $n['args']);
        $init = $this->findMethod($inst, 'init', $s);
        if ($init) $this->callMethod($inst, $init, $args);
        return $inst;
    }

    private function findMethod(YLInstance $inst, string $name, Scope $s): ?YLFunction {
        $c = $inst->class;
        while ($c) {
            if (isset($c->methods[$name])) {
                $m = $c->methods[$name];
                return new YLFunction($m['params'], $m['paramTypes'], $m['body'], $s,
                    $m['retType'], $name, $m['isGenerator']);
            }
            if ($c->parent) {
                try { $p = $s->get($c->parent); $c = $p instanceof YLClass ? $p : null; }
                catch (\Throwable) { $c = null; }
            } else $c = null;
        }
        return null;
    }

    private function doMethodCall(array $n, Scope $s): mixed {
        $t = $this->eval($n['target'], $s);
        $args = array_map(fn($a) => $this->eval($a, $s), $n['args']);
        if ($t instanceof YLInstance) {
            $m = $this->findMethod($t, $n['method'], $s);
            if (!$m) throw new RuntimeException("Метод '{$n['method']}' не найден");
            return $this->callMethod($t, $m, $args);
        }
        if ($t instanceof YLModule) {
            if (!array_key_exists($n['method'], $t->vars))
                throw new RuntimeException("Модуль не содержит '{$n['method']}'");
            $fn = $t->vars[$n['method']];
            if ($fn instanceof YLFunction) return $this->callUser($fn, $args);
        }
        $handled = null;
        if ($this->callBuiltin($n['method'], array_merge([$t], $args), $s, $handled)) return $handled;
        throw new RuntimeException("Метод '{$n['method']}' не найден у " . $this->typeName($t));
    }

    private function callMethod(YLInstance $inst, YLFunction $fn, array $args): mixed {
        $scope = new Scope($fn->closure);
        $scope->define('this', $inst);
        foreach ($fn->params as $i => $p) {
            $v = $args[$i] ?? null;
            $ty = $fn->paramTypes[$i] ?? null;
            if ($ty) $this->typeCheck($v, $ty, "параметр '$p'");
            $scope->define($p, $v);
        }
        try { $this->execBlock($fn->body, $scope); return null; }
        catch (ReturnException $e) { return $e->value; }
    }

    private function doCall(array $n, Scope $s): mixed {
        if ($n['callee']['type'] !== 'Ident') throw new RuntimeException('Только именованные вызовы');
        $name = $n['callee']['name'];
        $args = array_map(fn($a) => $this->eval($a, $s), $n['args']);
        $handled = null;
        if ($this->callBuiltin($name, $args, $s, $handled)) return $handled;
        $fn = $s->get($name);
        if ($fn instanceof YLFunction) {
            if ($fn->isGenerator) return new YLGenerator($fn, $args, $this);
            if ($fn->isAsync) return new AsyncTask($fn, $args, $this);
            return $this->callUser($fn, $args);
        }
        throw new RuntimeException("'$name' не функция");
    }

    public function callUser(YLFunction $fn, array $args): mixed {
        $scope = new Scope($fn->closure);
        foreach ($fn->params as $i => $p) {
            $v = $args[$i] ?? null;
            $ty = $fn->paramTypes[$i] ?? null;
            if ($ty) $this->typeCheck($v, $ty, "параметр '$p'");
            $scope->define($p, $v);
        }
        try { $this->execBlock($fn->body, $scope); return null; }
        catch (ReturnException $e) { return $e->value; }
    }

    private function binop(string $op, mixed $l, mixed $r): mixed {
        return match ($op) {
            '+'  => (is_string($l) || is_string($r)) ? $this->toStr($l) . $this->toStr($r) : $l + $r,
            '-'  => $l - $r, '*' => $l * $r,
            '/'  => $r == 0 ? throw new RuntimeException('Деление на ноль') : $l / $r,
            '%'  => $l % $r,
            '==' => $l == $r, '!=' => $l != $r,
            '<'  => $l <  $r, '>'  => $l >  $r, '<=' => $l <= $r, '>=' => $l >= $r,
            '&&' => $this->truthy($l) && $this->truthy($r),
            '||' => $this->truthy($l) || $this->truthy($r),
            default => throw new RuntimeException("Неизвестный оператор: $op"),
        };
    }

    private function callBuiltin(string $name, array $a, Scope $s, &$out): bool {
        $out = null;
        switch ($name) {
            case 'len':   $out = is_array($a[0] ?? null) ? count($a[0]) : mb_strlen($this->toStr($a[0] ?? ''), 'UTF-8'); return true;
            case 'str':   $out = $this->toStr($a[0] ?? null); return true;
            case 'num':   $out = is_numeric($a[0] ?? null) ? $a[0] + 0 : 0; return true;
            case 'type':  $out = $this->typeName($a[0] ?? null); return true;
            case 'upper': $out = mb_strtoupper($this->toStr($a[0] ?? ''), 'UTF-8'); return true;
            case 'lower': $out = mb_strtolower($this->toStr($a[0] ?? ''), 'UTF-8'); return true;
            case 'trim':  $out = trim($this->toStr($a[0] ?? '')); return true;
            case 'split': $out = explode($this->toStr($a[1] ?? ' '), $this->toStr($a[0] ?? '')); return true;
            case 'join':  $out = implode($this->toStr($a[1] ?? ''), array_map(fn($x)=>$this->toStr($x), $a[0] ?? [])); return true;
            case 'abs':   $out = abs($a[0] ?? 0); return true;
            case 'floor': $out = (int)floor((float)($a[0] ?? 0)); return true;
            case 'ceil':  $out = (int)ceil((float)($a[0] ?? 0)); return true;
            case 'round': $out = (int)round((float)($a[0] ?? 0)); return true;
            case 'min':   $out = min($a); return true;
            case 'max':   $out = max($a); return true;
            case 'sqrt':  $out = sqrt((float)($a[0] ?? 0)); return true;
            case 'rand':  $out = random_int((int)($a[0] ?? 0), (int)($a[1] ?? PHP_INT_MAX)); return true;
            case 'range': $out = range((int)($a[0] ?? 0), (int)($a[1] ?? 0)); return true;
            case 'push':
                $arr = $a[0] ?? []; if (!is_array($arr)) $arr = [];
                $arr[] = $a[1] ?? null; $out = $arr; return true;
            case 'pop':
                $arr = $a[0] ?? []; if (is_array($arr)) array_pop($arr);
                $out = $arr; return true;
            case 'keys': $out = array_keys($a[0] ?? []); return true;
            case 'vals': $out = array_values($a[0] ?? []); return true;
            case 'assert':
                if (!$this->truthy($a[0] ?? false)) throw new RuntimeException('Assert: ' . ($a[1] ?? 'failed'));
                $out = true; return true;
            case 'map':
                $arr = $a[0] ?? []; $fn = $a[1] ?? null;
                if (!$fn instanceof YLFunction) throw new RuntimeException('map: нужна функция');
                $out = array_map(fn($x) => $this->callUser($fn, [$x]), $arr); return true;
            case 'filter':
                $arr = $a[0] ?? []; $fn = $a[1] ?? null;
                if (!$fn instanceof YLFunction) throw new RuntimeException('filter: нужна функция');
                $out = array_values(array_filter($arr, fn($x) => $this->truthy($this->callUser($fn, [$x])))); return true;
            case 'reduce':
                $arr = $a[0] ?? []; $fn = $a[1] ?? null; $acc = $a[2] ?? null;
                if (!$fn instanceof YLFunction) throw new RuntimeException('reduce: нужна функция');
                foreach ($arr as $x) $acc = $this->callUser($fn, [$acc, $x]);
                $out = $acc; return true;
            case 'read': if (isset($a[0])) echo $this->toStr($a[0]); $out = trim((string)fgets(STDIN)); return true;
            case 'readfile': $this->guardIO(); $p = $this->toStr($a[0] ?? ''); if (!is_file($p)) throw new RuntimeException("Файл не найден: $p"); $out = (string)file_get_contents($p); return true;
            case 'writefile': $this->guardIO(); file_put_contents($this->toStr($a[0] ?? ''), $this->toStr($a[1] ?? '')); $out = true; return true;
            case 'appendfile': $this->guardIO(); file_put_contents($this->toStr($a[0] ?? ''), $this->toStr($a[1] ?? ''), FILE_APPEND); $out = true; return true;
            case 'exists': $out = is_file($this->toStr($a[0] ?? '')); return true;
            case 'eval': $this->guardEval(); $out = $this->evalSource($this->toStr($a[0] ?? ''), $s); return true;
            case 'exit': exit((int)($a[0] ?? 0));
            case 'time': $out = microtime(true); return true;

            // ---- v4: JSON / HTTP / DATETIME ----
            case 'json_parse':
                $v = json_decode($this->toStr($a[0] ?? ''), true);
                if (json_last_error() !== JSON_ERROR_NONE) throw new RuntimeException('JSON: ' . json_last_error_msg());
                $out = $v; return true;
            case 'json_str':
                $out = json_encode($a[0] ?? null, JSON_UNESCAPED_UNICODE); return true;
            case 'json_str_pretty':
                $out = json_encode($a[0] ?? null, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); return true;
            case 'http_get':
                $this->guardIO();
                $url = $this->toStr($a[0] ?? '');
                $ctx = stream_context_create(['http' => ['method'=>'GET','timeout'=>15,'ignore_errors'=>true]]);
                $r = @file_get_contents($url, false, $ctx);
                if ($r === false) throw new RuntimeException("GET не удался: $url");
                $out = $r; return true;
            case 'http_post':
                $this->guardIO();
                $url = $this->toStr($a[0] ?? '');
                $body = $this->toStr($a[1] ?? '');
                $ctx = stream_context_create(['http' => ['method'=>'POST','header'=>'Content-Type: application/json','content'=>$body,'timeout'=>15,'ignore_errors'=>true]]);
                $r = @file_get_contents($url, false, $ctx);
                if ($r === false) throw new RuntimeException("POST не удался: $url");
                $out = $r; return true;
            case 'now':       $out = time(); return true;
            case 'date_fmt':  $out = date($this->toStr($a[1] ?? 'Y-m-d H:i:s'), (int)($a[0] ?? time())); return true;
            case 'sleep_ms':  usleep((int)($a[0] ?? 0) * 1000); $out = null; return true;
        }
        return false;
    }

    private function doImport(array $n, Scope $s): void {
        $this->guardIO();
        $path = $n['path'];
        $resolved = Env::$moduleCache[$path] ?? null;
        if ($resolved === null) {
            $base = $GLOBALS['__YL_BASE__'] ?? getcwd();
            $abs = is_file($path) ? $path : $base . DIRECTORY_SEPARATOR . $path;
            if (!is_file($abs)) throw new RuntimeException("Модуль не найден: $path");
            $src = (string)file_get_contents($abs);
            $ast = (new Parser((new Lexer($src))->tokenize()))->parse();
            $mod = new Interpreter();
            $mod->runProgram($ast);
            $resolved = new YLModule($mod->global->vars);
            Env::$moduleCache[$path] = $resolved;
        }
        $alias = $n['alias'] ?? preg_replace('/\.yl$/', '', basename($path));
        $s->define($alias, $resolved);
    }

    public function evalSource(string $src, Scope $s): mixed {
        $ast = (new Parser((new Lexer($src))->tokenize()))->parse();
        $result = null;
        foreach ($ast['body'] as $st) {
            if ($st['type'] === 'ExprStmt') $result = $this->eval($st['expr'], $s);
            else $this->exec($st, $s);
        }
        return $result;
    }

    private function typeCheck(mixed $v, string $ty, string $where): void {
        $ok = match ($ty) {
            'int'   => is_int($v),
            'float' => is_float($v) || is_int($v),
            'str'   => is_string($v),
            'bool'  => is_bool($v),
            'arr'   => is_array($v),
            'fn'    => $v instanceof YLFunction,
            'obj'   => $v instanceof YLInstance,
            'null'  => $v === null,
            'any'   => true,
            default => throw new RuntimeException("Неизвестный тип: $ty"),
        };
        if (!$ok) throw new RuntimeException("Тип не совпадает: $where ожидает $ty, получено " . $this->typeName($v));
    }

    private function guardIO(): void { if (Env::$sandbox) throw new RuntimeException('I/O запрещён в песочнице'); }
    private function guardEval(): void { if (Env::$sandbox) throw new RuntimeException('eval запрещён в песочнице'); }

    private function truthy(mixed $v): bool {
        if (is_bool($v)) return $v;
        if ($v === null) return false;
        if (is_numeric($v)) return $v != 0;
        if (is_string($v)) return $v !== '';
        if (is_array($v)) return count($v) > 0;
        return (bool)$v;
    }
    public function typeName(mixed $v): string {
        return match (true) {
            $v === null => 'null', is_bool($v) => 'bool', is_int($v) => 'int',
            is_float($v) => 'float', is_string($v) => 'str', is_array($v) => 'arr',
            $v instanceof YLFunction => 'fn', $v instanceof YLModule => 'module',
            $v instanceof YLClass => 'class', $v instanceof YLInstance => $v->class->name,
            $v instanceof YLGenerator => 'generator', $v instanceof AsyncTask => 'task',
            default => 'unknown',
        };
    }
    public function toStr(mixed $v): string {
        if ($v === null) return '∅';
        if ($v === true) return '☑';
        if ($v === false) return '☐';
        if (is_array($v)) return '[' . implode(', ', array_map(fn($x) => $this->toStr($x), $v)) . ']';
        if ($v instanceof YLFunction) return '<функция>';
        if ($v instanceof YLModule) return '<модуль>';
        if ($v instanceof YLClass) return '<класс ' . $v->name . '>';
        if ($v instanceof YLGenerator) return '<генератор>';
        if ($v instanceof AsyncTask) return '<задача>';
        if ($v instanceof YLInstance) return $v->class->name . '⟪' . implode(', ', array_map(
            fn($k,$x)=>"$k=" . $this->toStr($x), array_keys($v->fields), array_values($v->fields)
        )) . '⟫';
        return (string)$v;
    }
}

/* ==================== REPL v4 ==================== */
function repl(): void {
    // YL-REPL-V4
    echo "YL REPL v4. Выход: 'выход' / 'exit' / ':q'  |  Помощь: ':help'\n";
    $interp = new Interpreter();
    $prel = __DIR__ . '/std/prelude.yl';
    if (is_file($prel)) {
        try {
            $ast = (new Parser((new Lexer((string)file_get_contents($prel)))->tokenize()))->parse();
            $interp->runProgram($ast);
        } catch (\Throwable $e) { fwrite(STDERR, "prelude: " . $e->getMessage() . "\n"); }
    }
    $buffer = '';
    while (true) {
        fwrite(STDOUT, $buffer === '' ? "yl> " : "..> ");
        $line = fgets(STDIN);
        if ($line === false) { echo "\n"; break; }
        $line = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $line);
        if ($buffer === '') {
            $line = preg_replace('/(?:^\s*(?:yl|\.\.)>\s?)+/', '', $line);
        }
        $trim = trim($line);
        if ($buffer === '') {
            if ($trim === '') continue;
            if (in_array($trim, ['выход', 'exit', 'quit', ':q'], true)) break;
            if ($trim === ':help' || $trim === ':h') {
                echo "  :help / :h        — помощь\n";
                echo "  :vars             — переменные\n";
                echo "  :load <файл>      — выполнить .yl\n";
                echo "  выход / exit / :q — выйти\n";
                echo "  Многострочный ввод: пока не сбалансированы ⟦ ⟧.\n";
                continue;
            }
            if ($trim === ':vars') {
                foreach ($interp->global->vars as $k => $v) {
                    if ($v instanceof YLFunction || $v instanceof YLClass || $v instanceof YLModule) continue;
                    echo "  $k = " . $interp->toStr($v) . "\n";
                }
                continue;
            }
            if (str_starts_with($trim, ':load ')) {
                $path = trim(substr($trim, 6));
                if (!is_file($path)) { fwrite(STDERR, "не найден: $path\n"); continue; }
                try {
                    $ast = (new Parser((new Lexer((string)file_get_contents($path)))->tokenize()))->parse();
                    $interp->runProgram($ast);
                } catch (\Throwable $e) { fwrite(STDERR, "! " . $e->getMessage() . "\n"); }
                continue;
            }
        }
        $buffer .= $line;
        $open = substr_count($buffer, Sym::$m['open']);
        $close = substr_count($buffer, Sym::$m['close']);
        if ($open > $close) continue;
        try {
            $ast = (new Parser((new Lexer($buffer))->tokenize()))->parse();
            if (count($ast['body']) === 1 && $ast['body'][0]['type'] === 'ExprStmt') {
                $r = $interp->evalSource($buffer, $interp->global);
                if ($r !== null) echo $interp->toStr($r) . "\n";
            } else {
                $interp->runProgram($ast);
            }
        } catch (\Throwable $e) {
            fwrite(STDERR, "! " . $e->getMessage() . "\n");
        }
        $buffer = '';
    }
}/* ==================== ТОЧКА ВХОДА ==================== */
/* === ENTRY-GUARD === */
if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') !== realpath(__FILE__)) {
    return;
}


function usage(): void {
    fwrite(STDERR, "Использование: yl.php [--sandbox] [--symbols=cfg.json] [--repl | <файл.yl>]\n");
}

$args = array_slice($argv, 1);
$file = null;
$wantRepl = false;
foreach ($args as $a) {
    if ($a === '--sandbox') Env::$sandbox = true;
    elseif ($a === '--repl') $wantRepl = true;
    elseif (str_starts_with($a, '--symbols=')) Sym::load(substr($a, 10));
    elseif (str_starts_with($a, '--')) { usage(); exit(1); }
    else $file = $a;
}

if ($wantRepl || $file === null) { repl(); exit(0); }
if (!is_file($file)) { fwrite(STDERR, "Файл не найден: $file\n"); exit(1); }

$GLOBALS['__YL_BASE__'] = dirname(realpath($file));
try {
    $interp = new Interpreter();
    $prel = __DIR__ . '/std/prelude.yl';
    if (is_file($prel)) {
        $ast = (new Parser((new Lexer((string)file_get_contents($prel)))->tokenize()))->parse();
        $interp->runProgram($ast);
    }
    $src = (string)file_get_contents($file);
    $ast = (new Parser((new Lexer($src))->tokenize()))->parse();
    $interp->runProgram($ast);
} catch (\Throwable $e) {
    fwrite(STDERR, "Ошибка YL: " . $e->getMessage() . "\n");
    exit(1);
}