<?php
declare(strict_types=1);

final class YLScope {
    public array $vars = [];
    public ?YLScope $parent;
    public function __construct(?YLScope $parent = null) { $this->parent = $parent; }
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
        public YLScope $closure, public ?string $retType = null, public ?string $name = null,
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
final class AsyncTask {
    public mixed $result = null;
    public bool $done = false;
    public function __construct(public YLFunction $fn, public array $args) {}
}

function yl_get(YLScope $s, string $n): mixed { return $s->get($n); }

function yl_truthy(mixed $v): bool {
    if (is_bool($v)) return $v;
    if ($v === null) return false;
    if (is_numeric($v)) return $v != 0;
    if (is_string($v)) return $v !== '';
    if (is_array($v)) return count($v) > 0;
    return (bool)$v;
}

function yl_str(mixed $v): string {
    if ($v === null) return '∅';
    if ($v === true) return '☑';
    if ($v === false) return '☐';
    if (is_array($v)) return '[' . implode(', ', array_map('yl_str', $v)) . ']';
    if ($v instanceof Closure) return '<функция>';
    if ($v instanceof YLFunction) return '<функция>';
    if ($v instanceof YLModule) return '<модуль>';
    if ($v instanceof YLClass) return '<класс ' . $v->name . '>';
    if ($v instanceof YLInstance) return $v->class->name . '⟪' . implode(', ', array_map(
        fn($k,$x)=>"$k=" . yl_str($x), array_keys($v->fields), array_values($v->fields)
    )) . '⟫';
    return (string)$v;
}

function yl_binop(string $op, mixed $l, mixed $r): mixed {
    return match ($op) {
        '+'  => (is_string($l) || is_string($r)) ? yl_str($l) . yl_str($r) : $l + $r,
        '-'  => $l - $r, '*' => $l * $r,
        '/'  => $r == 0 ? throw new RuntimeException('Деление на ноль') : $l / $r,
        '%'  => $l % $r,
        '==' => $l == $r, '!=' => $l != $r,
        '<'  => $l <  $r, '>'  => $l >  $r, '<=' => $l <= $r, '>=' => $l >= $r,
        '&&' => yl_truthy($l) && yl_truthy($r),
        '||' => yl_truthy($l) || yl_truthy($r),
        default => throw new RuntimeException("Неизвестный оператор: $op"),
    };
}

function yl_call(YLScope $s, string $name, array $args): mixed {
    $b = yl_builtin($name, $args);
    if ($b !== null) return $b[1];
    $fn = $s->get($name);
    // PHP Closure (скомпилированная лямбда или функция)
    if ($fn instanceof Closure) return $fn(...$args);
    if ($fn instanceof YLFunction) {
        // интерпретатор не подключён; для YLFunction — просто вернём null
        // (в скомпилированном коде YLFunction не появляется)
        throw new RuntimeException("YLFunction в компиляторе не поддерживается");
    }
    throw new RuntimeException("'$name' не функция");
}

function yl_builtin(string $name, array $a): ?array {
    switch ($name) {
        case 'len':   return [true, is_array($a[0] ?? null) ? count($a[0]) : mb_strlen(yl_str($a[0] ?? ''), 'UTF-8')];
        case 'str':   return [true, yl_str($a[0] ?? null)];
        case 'num':   return [true, is_numeric($a[0] ?? null) ? $a[0] + 0 : 0];
        case 'type':  return [true, yl_type($a[0] ?? null)];
        case 'upper': return [true, mb_strtoupper(yl_str($a[0] ?? ''), 'UTF-8')];
        case 'lower': return [true, mb_strtolower(yl_str($a[0] ?? ''), 'UTF-8')];
        case 'trim':  return [true, trim(yl_str($a[0] ?? ''))];
        case 'split': return [true, explode(yl_str($a[1] ?? ' '), yl_str($a[0] ?? ''))];
        case 'join':  return [true, implode(yl_str($a[1] ?? ''), array_map('yl_str', $a[0] ?? []))];
        case 'abs':   return [true, abs($a[0] ?? 0)];
        case 'floor': return [true, (int)floor((float)($a[0] ?? 0))];
        case 'ceil':  return [true, (int)ceil((float)($a[0] ?? 0))];
        case 'round': return [true, (int)round((float)($a[0] ?? 0))];
        case 'min':   return [true, min($a)];
        case 'max':   return [true, max($a)];
        case 'sqrt':  return [true, sqrt((float)($a[0] ?? 0))];
        case 'rand':  return [true, random_int((int)($a[0] ?? 0), (int)($a[1] ?? PHP_INT_MAX))];
        case 'range': return [true, range((int)($a[0] ?? 0), (int)($a[1] ?? 0))];
        case 'push':
            $x = $a[0] ?? []; if (!is_array($x)) $x = [];
            $x[] = $a[1] ?? null; return [true, $x];
        case 'pop':
            $x = $a[0] ?? []; if (is_array($x)) array_pop($x);
            return [true, $x];
        case 'keys': return [true, array_keys($a[0] ?? [])];
        case 'vals': return [true, array_values($a[0] ?? [])];

        case 'map':
            $arr = $a[0] ?? []; $fn = $a[1] ?? null;
            if (!($fn instanceof Closure || $fn instanceof YLFunction)) return [true, []];
            return [true, array_map(fn($x) => $fn($x), $arr)];

        case 'filter':
            $arr = $a[0] ?? []; $fn = $a[1] ?? null;
            if (!($fn instanceof Closure || $fn instanceof YLFunction)) return [true, []];
            return [true, array_values(array_filter($arr, fn($x) => yl_truthy($fn($x))))];

        case 'reduce':
            $arr = $a[0] ?? []; $fn = $a[1] ?? null; $acc = $a[2] ?? null;
            if (!($fn instanceof Closure || $fn instanceof YLFunction)) return [true, $acc];
            foreach ($arr as $x) $acc = $fn($acc, $x);
            return [true, $acc];

        case 'json_parse':
            $v = json_decode(yl_str($a[0] ?? ''), true);
            if (json_last_error() !== JSON_ERROR_NONE) throw new RuntimeException('JSON: ' . json_last_error_msg());
            return [true, $v];
        case 'json_str':        return [true, json_encode($a[0] ?? null, JSON_UNESCAPED_UNICODE)];
        case 'json_str_pretty': return [true, json_encode($a[0] ?? null, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)];
        case 'now':             return [true, time()];
        case 'date_fmt':        return [true, date(yl_str($a[1] ?? 'Y-m-d H:i:s'), (int)($a[0] ?? time()))];
        case 'sleep_ms':        usleep((int)($a[0] ?? 0) * 1000); return [true, null];

        case 'eval':
            // В скомпилированном коде eval недоступен
            throw new RuntimeException('eval недоступен в компилированной программе');

        case 'readfile':
            $p = yl_str($a[0] ?? '');
            if (!is_file($p)) throw new RuntimeException("Файл не найден: $p");
            return [true, (string)file_get_contents($p)];
        case 'writefile':
            file_put_contents(yl_str($a[0] ?? ''), yl_str($a[1] ?? ''));
            return [true, true];
        case 'appendfile':
            file_put_contents(yl_str($a[0] ?? ''), yl_str($a[1] ?? ''), FILE_APPEND);
            return [true, true];
        case 'exists':
            return [true, is_file(yl_str($a[0] ?? ''))];
    }
    return null;
}

function yl_type(mixed $v): string {
    return match (true) {
        $v === null => 'null',
        is_bool($v) => 'bool',
        is_int($v) => 'int',
        is_float($v) => 'float',
        is_string($v) => 'str',
        is_array($v) => 'arr',
        $v instanceof Closure => 'fn',
        $v instanceof YLFunction => 'fn',
        $v instanceof YLModule => 'module',
        $v instanceof YLClass => 'class',
        $v instanceof YLInstance => $v->class->name,
        default => 'unknown',
    };
}

function yl_iter(mixed $v): iterable {
    if (is_array($v)) return $v;
    if ($v instanceof Generator) return $v;
    return [];
}

function yl_await(mixed $v): mixed {
    if ($v instanceof AsyncTask) return $v->result;
    return $v;
}

function yl_new(YLScope $s, string $cls, array $args): YLInstance {
    $c = $s->get($cls);
    if (!$c instanceof YLClass) throw new RuntimeException("'$cls' не класс");
    return new YLInstance($c);
}

function yl_member(mixed $t, string $n): mixed {
    if ($t instanceof YLInstance) return $t->fields[$n] ?? null;
    if ($t instanceof YLModule) return $t->vars[$n] ?? null;
    return null;
}

function yl_method(mixed $t, string $m, array $args): mixed {
    // модули в компиляторе не поддержаны — возвращаем null вместо падения
    if ($t instanceof YLModule) {
        $fn = $t->vars[$m] ?? null;
        if ($fn instanceof Closure) return $fn(...$args);
        return null;
    }
    if ($t instanceof YLInstance) {
        // методы классов в компиляторе не поддержаны
        return null;
    }
    // builtins через метод: arr.push(x) и т.п.
    $b = yl_builtin($m, array_merge([$t], $args));
    return $b !== null ? $b[1] : null;
}

function yl_import(string $path, ?string $alias, YLScope $s): void {
    // Компилятор не умеет подгружать .yl-модули.
    // Заглушка, чтобы программа не падала на m.xxx — просто вернёт null.
    $alias = $alias ?? preg_replace('/\.yl$/', '', basename($path));
    $s->define($alias, new YLModule([]));
}