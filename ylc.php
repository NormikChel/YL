#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/yl.php';

final class Compiler {
    private array $out = [];
    private array $localStack = [];

    public function __construct(private array $ast) {}

    private function emit(string $line): void { $this->out[] = $line; }

    private function pushLocals(array $names): void { $this->localStack[] = array_flip($names); }
    private function popLocals(): void { array_pop($this->localStack); }

    private function isLocal(string $name): bool {
        for ($i = count($this->localStack) - 1; $i >= 0; $i--) {
            if (isset($this->localStack[$i][$name])) return true;
        }
        return false;
    }

    public function compile(): string {
        $this->emit('<?php declare(strict_types=1);');
        $this->emit('require_once ' . var_export(__DIR__ . '/ylc_runtime.php', true) . ';');
        $this->emit('$S = new YLScope();');

        foreach ($this->ast['body'] as $n) {
            if ($n['type'] === 'ClassDef') {
                $this->emit('/* ClassDef ' . $n['name'] . ' пропущен — не поддержан компилятором */');
                continue;
            }
            $this->stmt($n, '$S');
        }
        return implode("\n", $this->out);
    }

    private function stmt(array $n, string $scope): void {
        switch ($n['type']) {
            case 'Decl':
                $this->emit($scope . '->define(' . var_export($n['name'], true) . ', ' . $this->expr($n['value'], $scope) . ');');
                break;

            case 'DeclDestruct':
                $tmp = '$__d' . uniqid();
                $this->emit($tmp . ' = ' . $this->expr($n['value'], $scope) . ';');
                foreach ($n['names'] as $i => $nm) {
                    $key = $n['mode'] === 'array' ? $i : $nm;
                    $this->emit($scope . '->define(' . var_export($nm, true) . ', ' . $tmp . '[' . var_export($key, true) . '] ?? null);');
                }
                break;

            case 'Assign':
                if ($this->isLocal($n['name'])) {
                    $this->emit('$' . $n['name'] . ' = ' . $this->expr($n['value'], $scope) . ';');
                } else {
                    $this->emit($scope . '->set(' . var_export($n['name'], true) . ', ' . $this->expr($n['value'], $scope) . ');');
                }
                break;

            case 'SetMember':
                $this->emit($this->expr($n['target'], $scope) . '->' . $n['name'] . ' = ' . $this->expr($n['value'], $scope) . ';');
                break;

            case 'SetIndex':
                $t = $this->expr($n['target'], $scope);
                $i = $this->expr($n['index'], $scope);
                $v = $this->expr($n['value'], $scope);
                $this->emit($t . '[' . $i . '] = ' . $v . ';');
                if ($n['target']['type'] === 'Ident' && !$this->isLocal($n['target']['name'])) {
                    $this->emit($scope . '->set(' . var_export($n['target']['name'], true) . ', ' . $t . ');');
                }
                break;

            case 'FuncDef':
                $paramsStr = implode(', ', array_map(fn($p) => '$' . $p, $n['params']));
                $this->emit($scope . '->define(' . var_export($n['name'], true) . ', function(' . $paramsStr . ') use (' . $scope . ') {');
                $this->pushLocals($n['params']);
                foreach ($n['body'] as $s) $this->stmt($s, '$__inner');
                $this->popLocals();
                $this->emit('});');
                break;

            case 'ClassDef':
                break;

            case 'Print':
                $parts = array_map(fn($e) => 'yl_str(' . $this->expr($e, $scope) . ')', $n['values']);
                $this->emit('echo implode(" ", [' . implode(', ', $parts) . ']) . "\n";');
                break;

            case 'ExprStmt':
                $this->emit($this->expr($n['expr'], $scope) . ';');
                break;

            case 'Assert':
                $cond = $this->expr($n['cond'], $scope);
                $msg = $n['msg'] ? $this->expr($n['msg'], $scope) : '"assertion failed"';
                $this->emit('if (!yl_truthy(' . $cond . ')) throw new RuntimeException("Assert: " . yl_str(' . $msg . '));');
                break;

            case 'If':
                $this->emit('if (yl_truthy(' . $this->expr($n['cond'], $scope) . ')) {');
                $this->emit('    $__b = new YLScope(' . $scope . ');');
                foreach ($n['then'] as $s) $this->stmt($s, '$__b');
                $this->emit('}');
                if ($n['else']) {
                    $this->emit('else {');
                    $this->emit('    $__b = new YLScope(' . $scope . ');');
                    foreach ($n['else'] as $s) $this->stmt($s, '$__b');
                    $this->emit('}');
                }
                break;

            case 'While':
                $this->emit('while (yl_truthy(' . $this->expr($n['cond'], $scope) . ')) {');
                $this->emit('    $__b = new YLScope(' . $scope . ');');
                foreach ($n['body'] as $s) $this->stmt($s, '$__b');
                $this->emit('}');
                break;

            case 'For':
                $v = $n['var'];
                $from = $this->expr($n['from'], $scope);
                $to = $this->expr($n['to'], $scope);
                $this->emit('for ($' . $v . ' = ' . $from . '; $' . $v . ' < ' . $to . '; $' . $v . '++) {');
                $this->emit('    $__b = new YLScope(' . $scope . ');');
                $this->emit('    $__b->define(' . var_export($v, true) . ', $' . $v . ');');
                foreach ($n['body'] as $s) $this->stmt($s, '$__b');
                $this->emit('}');
                break;

            case 'Foreach':
                $v = $n['var'];
                $this->emit('foreach (yl_iter(' . $this->expr($n['iter'], $scope) . ') as $' . $v . ') {');
                $this->emit('    $__b = new YLScope(' . $scope . ');');
                $this->emit('    $__b->define(' . var_export($v, true) . ', $' . $v . ');');
                foreach ($n['body'] as $s) $this->stmt($s, '$__b');
                $this->emit('}');
                break;

            case 'Return':
                $this->emit('return ' . ($n['value'] ? $this->expr($n['value'], $scope) : 'null') . ';');
                break;

            case 'Yield':
                $this->emit('yield ' . $this->expr($n['value'], $scope) . ';');
                break;

            case 'Break':    $this->emit('break;'); break;
            case 'Continue': $this->emit('continue;'); break;

            case 'Try':
                $this->emit('try {');
                $this->emit('    $__b = new YLScope(' . $scope . ');');
                foreach ($n['body'] as $s) $this->stmt($s, '$__b');
                $this->emit('} catch (Throwable $__e) {');
                if ($n['catchBody'] !== null) {
                    $this->emit('    $__b = new YLScope(' . $scope . ');');
                    $this->emit('    $__b->define(' . var_export($n['catchVar'], true) . ', $__e->getMessage());');
                    foreach ($n['catchBody'] as $s) $this->stmt($s, '$__b');
                } else {
                    $this->emit('    throw $__e;');
                }
                $this->emit('}');
                if ($n['finally'] !== null) {
                    $this->emit('finally {');
                    $this->emit('    $__b = new YLScope(' . $scope . ');');
                    foreach ($n['finally'] as $s) $this->stmt($s, '$__b');
                    $this->emit('}');
                }
                break;

            case 'Import':
                $this->emit('yl_import(' . var_export($n['path'], true) . ', ' . var_export($n['alias'], true) . ', ' . $scope . ');');
                break;

            default:
                $this->emit('/* TODO: ' . $n['type'] . ' */');
        }
    }

    private function expr(array $n, string $scope): string {
        switch ($n['type']) {
            case 'Number': return var_export($n['value'], true);
            case 'String': return var_export($n['value'], true);
            case 'Bool':   return $n['value'] ? 'true' : 'false';
            case 'Null':   return 'null';

            case 'Ident':
                if ($this->isLocal($n['name'])) return '$' . $n['name'];
                return $scope . '->get(' . var_export($n['name'], true) . ')';

            case 'Array':
                return '[' . implode(', ', array_map(fn($i) => $this->expr($i, $scope), $n['items'])) . ']';

            case 'Dict':
                $p = [];
                foreach ($n['pairs'] as $k => $v) $p[] = var_export($k, true) . ' => ' . $this->expr($v, $scope);
                return '[' . implode(', ', $p) . ']';

            case 'BinOp':
                return 'yl_binop(' . var_export($n['op'], true) . ', ' .
                    $this->expr($n['left'], $scope) . ', ' . $this->expr($n['right'], $scope) . ')';

            case 'UnaryOp':
                return $n['op'] . '(' . $this->expr($n['expr'], $scope) . ')';

            case 'Await':
                return 'yl_await(' . $this->expr($n['expr'], $scope) . ')';

            case 'Call':
                $name = $n['callee']['name'];
                $args = implode(', ', array_map(fn($a) => $this->expr($a, $scope), $n['args']));
                return 'yl_call(' . $scope . ', ' . var_export($name, true) . ', [' . $args . '])';

            case 'Index':
                return '(' . $this->expr($n['target'], $scope) . '[' . $this->expr($n['index'], $scope) . '] ?? null)';

            case 'Lambda':
                $paramsStr = implode(', ', array_map(fn($p) => '$' . $p, $n['params']));
                $this->pushLocals($n['params']);
                $body = '';
                foreach ($n['body'] as $s) {
                    if ($s['type'] === 'Return') $body .= 'return ' . $this->expr($s['value'], $scope) . ';';
                    elseif ($s['type'] === 'ExprStmt') $body .= $this->expr($s['expr'], $scope) . ';';
                }
                $this->popLocals();
                return 'function(' . $paramsStr . ') use (' . $scope . ') { ' . $body . ' }';

            case 'New':
                $args = implode(', ', array_map(fn($a) => $this->expr($a, $scope), $n['args']));
                return 'yl_new(' . $scope . ', ' . var_export($n['class'], true) . ', [' . $args . '])';

            case 'MemberAccess':
                return 'yl_member(' . $this->expr($n['target'], $scope) . ', ' . var_export($n['name'], true) . ')';

            case 'MethodCall':
                $args = implode(', ', array_map(fn($a) => $this->expr($a, $scope), $n['args']));
                return 'yl_method(' . $this->expr($n['target'], $scope) . ', ' . var_export($n['method'], true) . ', [' . $args . '])';
        }
        return 'null';
    }
}

$args = array_slice($argv, 1);
if (count($args) < 2) {
    fwrite(STDERR, "Использование: php ylc.php <вход.yl> <выход.php>\n");
    exit(1);
}
$src = (string)file_get_contents($args[0]);
$ast = (new Parser((new Lexer($src))->tokenize()))->parse();
$php = (new Compiler($ast))->compile();
file_put_contents($args[1], $php);
echo "Скомпилировано: {$args[0]} → {$args[1]}\n";