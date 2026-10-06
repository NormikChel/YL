<?php
/**
 * install.php — установщик YL v3
 * Запуск: php install.php
 */
declare(strict_types=1);
error_reporting(E_ALL);
mb_internal_encoding('UTF-8');

$base = __DIR__;
function w(string $rel, string $content): void {
    global $base;
    $path = $base . '/' . $rel;
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    file_put_contents($path, $content);
    echo "  + $rel (" . strlen($content) . " b)\n";
}

echo "Установка YL v3 в $base\n\n";

/* ============ std/prelude.yl ============ */
w('std/prelude.yl', <<<'YL'
~ std/prelude.yl — базовая библиотека YL v3

§ позиция(строка, подстрока) ⟦
    ¤ n = len(строка)
    ¤ m = len(подстрока)
    ? m == 0 ⟦ ^ 0 ⟧
    # i = 0 .. n - m + 1 ⟦
        ¤ ок = ☑
        # j = 0 .. m ⟦
            ? строка[i + j] != подстрока[j] ⟦
                ок = ☐
                ⊘
            ⟧
        ⟧
        ? ок ⟦ ^ i ⟧
    ⟧
    ^ -1
⟧

§ содержит(строка, подстрока) ⟦
    ^ позиция(строка, подстрока) >= 0
⟧

§ повтор(строка, n) ⟦
    ¤ out = ""
    # i = 0 .. n ⟦ out = out + строка ⟧
    ^ out
⟧

§ заменить(строка, что, на) ⟦
    ¤ pos = позиция(строка, что)
    ? pos < 0 ⟦ ^ строка ⟧
    ¤ л = len(что)
    ^ строка[0] + на + строка[pos + л]
⟧

§ сумма(массив) ⟦
    ¤ s = 0
    ⇶ x = массив ⟦ s = s + x ⟧
    ^ s
⟧

§ произведение(массив) ⟦
    ¤ s = 1
    ⇶ x = массив ⟦ s = s * x ⟧
    ^ s
⟧

§ среднее(массив) ⟦
    ? len(массив) == 0 ⟦ ^ 0 ⟧
    ^ сумма(массив) / len(массив)
⟧

§ сорт(массив) ⟦
    ¤ a = массив
    ¤ n = len(a)
    # i = 0 .. n ⟦
        # j = 0 .. n - i - 1 ⟦
            ? a[j] > a[j + 1] ⟦
                ¤ t = a[j]
                a[j] = a[j + 1]
                a[j + 1] = t
            ⟧
        ⟧
    ⟧
    ^ a
⟧

§ уникальные(массив) ⟦
    ¤ out = []
    ⇶ x = массив ⟦
        ? позиция(str(out), str(x)) < 0 ⟦ out = push(out, x) ⟧
    ⟧
    ^ out
⟧

§ факториал(n) ⟦
    ? n <= 1 ⟦ ^ 1 ⟧
    ^ n * факториал(n - 1)
⟧

§ gcd(a, b) ⟦
    @ b != 0 ⟦
        ¤ t = b
        b = a % b
        a = t
    ⟧
    ^ a
⟧

§ макс_из(массив) ⟦
    ¤ m = массив[0]
    ⇶ x = массив ⟦ ? x > m ⟦ m = x ⟧ ⟧
    ^ m
⟧

§ мин_из(массив) ⟦
    ¤ m = массив[0]
    ⇶ x = массив ⟦ ? x < m ⟦ m = x ⟧ ⟧
    ^ m
⟧

§ even(x) ⟦ ^ x % 2 == 0 ⟧
§ odd(x)  ⟦ ^ x % 2 != 0 ⟧
YL
);

/* ============ std/math.yl ============ */
w('std/math.yl', <<<'YL'
~ std/math.yl
¤ PI = 3.14159265358979
§ степень(b, e) ⟦ ¤ r = 1; # i = 0 .. e ⟦ r = r * b ⟧ ^ r ⟧
§ sign(x) ⟦ ? x > 0 ⟦ ^ 1 ⟧ ? x < 0 ⟦ ^ -1 ⟧ ^ 0 ⟧
§ even(x) ⟦ ^ x % 2 == 0 ⟧
§ odd(x) ⟦ ^ x % 2 != 0 ⟧
§ clamp(x, lo, hi) ⟦ ^ min(max(x, lo), hi) ⟧
YL
);

/* ============ std/list.yl ============ */
w('std/list.yl', <<<'YL'
~ std/list.yl
§ head(a) ⟦ ^ a[0] ⟧
§ tail(a) ⟦ ¤ o = []; # i = 1 .. len(a) ⟦ o = push(o, a[i]) ⟧ ^ o ⟧
§ take(a, n) ⟦ ¤ o = []; # i = 0 .. n ⟦ ? i < len(a) ⟦ o = push(o, a[i]) ⟧ ⟧ ^ o ⟧
§ reverse(a) ⟦ ¤ o = []; # i = 0 .. len(a) ⟦ o = push(o, a[len(a) - i - 1]) ⟧ ^ o ⟧
§ flatten(a) ⟦ ¤ o = []; ⇶ x = a ⟦ ⇶ y = x ⟦ o = push(o, y) ⟧ ⟧ ^ o ⟧
§ zip(a, b) ⟦ ¤ o = []; ¤ n = min(len(a), len(b)); # i = 0 .. n ⟦ o = push(o, [a[i], b[i]]) ⟧ ^ o ⟧
YL
);

/* ============ std/string.yl ============ */
w('std/string.yl', <<<'YL'
~ std/string.yl
§ capital(s) ⟦ ^ upper(s[0]) + lower(s[1]) ⟧
§ реверс(s) ⟦ ¤ o = ""; # i = 0 .. len(s) ⟦ o = s[len(s) - i - 1] + o ⟧ ^ o ⟧
§ is_digit(s) ⟦ ¤ ok = ☑; # i = 0 .. len(s) ⟦ ¤ c = s[i]; ? !(c >= "0" && c <= "9") ⟦ ok = ☐ ⟧ ⟧ ^ ok ⟧
§ words(s) ⟦ ^ split(s, " ") ⟧
§ lines(s) ⟦ ^ split(s, "\n") ⟧
YL
);

/* ============ examples/oop.yl ============ */
w('examples/oop.yl', <<<'YL'
‡ Животное ⟦
    ⋔ init(имя :str) ⟦
        this.имя = имя
    ⟧
    ⋔ голос() ⟦
        ^ "..."
    ⟧
    ⋔ сказать() ⟦
        » this.имя + " говорит: " + this.голос()
    ⟧
⟧

‡ Собака † Животное ⟦
    ⋔ init(имя :str, порода :str) ⟦
        this.имя = имя
        this.порода = порода
    ⟧
    ⋔ голос() ⟦ ^ "Гав!" ⟧
⟧

‡ Кот † Животное ⟦
    ⋔ голос() ⟦ ^ "Мяу" ⟧
⟧

¤ рекс = ⇢ Собака("Рекс", "овчарка")
¤ борис = ⇢ Кот("Борис")

рекс.сказать()
борис.сказать()

» "Порода Рекса:", рекс.порода
YL
);

/* ============ examples/async.yl ============ */
w('examples/async.yl', <<<'YL'
~ YL v3 — генераторы + foreach
§ чётные(n) ⟦
    ¤ out = []
    # i = 0 .. n ⟦
        ? even(i) ⟦ out = push(out, i) ⟧
    ⟧
    ^ out
⟧

⇶ x = чётные(10) ⟦
    » "чётное:", x
⟧
YL
);

/* ============ ylc.php ============ */
w('ylc.php', <<<'PHP'
#!/usr/bin/env php
<?php
declare(strict_types=1);
require_once __DIR__ . '/yl.php';

final class Compiler {
    private array $out = [];
    private int $tmp = 0;
    public function __construct(private array $ast) {}
    private function line(string $s): void { $this->out[] = $s; }

    public function compile(): string {
        $this->line('<?php declare(strict_types=1);');
        $this->line('$__vars = [];');
        $this->line('$__funcs = [];');
        $this->line('function yl_get($n){ global $__vars; if(!array_key_exists($n,$__vars)) throw new RuntimeException("Undefined: $n"); return $__vars[$n]; }');
        $this->line('function yl_set($n,$v){ global $__vars; $__vars[$n]=$v; }');
        $this->line('function yl_binop($op,$l,$r){ return match($op){ "+"=>(is_string($l)||is_string($r))?(string)$l.(string)$r:$l+$r, "-"=>$l-$r, "*"=>$l*$r, "/"=>$r==0?throw new RuntimeException("div by zero"):$l/$r, "%"=>$l%$r, "=="=>$l==$r, "!="=>$l!=$r, "<"=>$l<$r, ">"=>$l>$r, "<="=>$l<=$r, ">="=>$l>=$r, "&&"=>(bool)$l&&(bool)$r, "||"=>(bool)$l||(bool)$r }; }');
        $this->line('function yl_str($v){ if($v===null)return "∅"; if($v===true)return "☑"; if($v===false)return "☐"; if(is_array($v))return "[".implode(", ",array_map("yl_str",$v))."]"; return (string)$v; }');
        foreach ($this->ast['body'] as $st) $this->stmt($st);
        return implode("\n", $this->out);
    }

    private function stmt(array $n): void {
        switch ($n['type']) {
            case 'Decl':
            case 'Assign':
                $this->line('yl_set(' . var_export($n['name'], true) . ', ' . $this->expr($n['value']) . ');');
                break;
            case 'Print':
                $parts = array_map(fn($e) => 'yl_str(' . $this->expr($e) . ')', $n['values']);
                $this->line('echo implode(" ", [' . implode(', ', $parts) . ']) . "\n";');
                break;
            case 'ExprStmt':
                $this->line($this->expr($n['expr']) . ';');
                break;
            case 'FuncDef':
                $this->line('$__funcs[' . var_export($n['name'], true) . '] = function(' .
                    implode(', ', array_map(fn($p) => '$' . $p, $n['params'])) . ') {');
                foreach ($n['body'] as $s) $this->stmt($s);
                $this->line('};');
                break;
            case 'If':
                $this->line('if (' . $this->expr($n['cond']) . ') {');
                foreach ($n['then'] as $s) $this->stmt($s);
                $this->line('}');
                if ($n['else']) {
                    $this->line('else {');
                    foreach ($n['else'] as $s) $this->stmt($s);
                    $this->line('}');
                }
                break;
            case 'While':
                $this->line('while (' . $this->expr($n['cond']) . ') {');
                foreach ($n['body'] as $s) $this->stmt($s);
                $this->line('}');
                break;
            case 'For':
                $v = $n['var'];
                $this->line('for ($' . $v . ' = ' . $this->expr($n['from']) . '; $' . $v . ' < ' .
                    $this->expr($n['to']) . '; $' . $v . '++) {');
                $this->line('yl_set(' . var_export($v, true) . ', $' . $v . ');');
                foreach ($n['body'] as $s) $this->stmt($s);
                $this->line('}');
                break;
            case 'Return':
                $this->line('return ' . ($n['value'] ? $this->expr($n['value']) : 'null') . ';');
                break;
            case 'Break': $this->line('break;'); break;
            case 'Continue': $this->line('continue;'); break;
            case 'Try':
                $this->line('try {');
                foreach ($n['body'] as $s) $this->stmt($s);
                $this->line('} catch (Throwable $__e) {');
                if ($n['catchBody'] !== null) {
                    $this->line('yl_set(' . var_export($n['catchVar'], true) . ', $__e->getMessage());');
                    foreach ($n['catchBody'] as $s) $this->stmt($s);
                } else $this->line('throw $__e;');
                $this->line('}');
                if ($n['finally'] !== null) {
                    $this->line('finally {');
                    foreach ($n['finally'] as $s) $this->stmt($s);
                    $this->line('}');
                }
                break;
            default:
                $this->line('/* TODO: ' . $n['type'] . ' */');
        }
    }

    private function expr(array $n): string {
        switch ($n['type']) {
            case 'Number': return var_export($n['value'], true);
            case 'String': return var_export($n['value'], true);
            case 'Bool':   return $n['value'] ? 'true' : 'false';
            case 'Null':   return 'null';
            case 'Ident':  return 'yl_get(' . var_export($n['name'], true) . ')';
            case 'Array':
                return '[' . implode(', ', array_map(fn($i) => $this->expr($i), $n['items'])) . ']';
            case 'Dict':
                $p = [];
                foreach ($n['pairs'] as $k => $v) $p[] = var_export($k, true) . ' => ' . $this->expr($v);
                return '[' . implode(', ', $p) . ']';
            case 'BinOp':
                return "yl_binop(" . var_export($n['op'], true) . ", " .
                    $this->expr($n['left']) . ", " . $this->expr($n['right']) . ")";
            case 'UnaryOp':
                return $n['op'] . '(' . $this->expr($n['expr']) . ')';
            case 'Call':
                $name = $n['callee']['name'];
                $args = implode(', ', array_map(fn($a) => $this->expr($a), $n['args']));
                return '$__funcs[' . var_export($name, true) . '](' . $args . ')';
            case 'Index':
                return '(' . $this->expr($n['target']) . '[' . $this->expr($n['index']) . '] ?? null)';
            case 'Lambda':
                $params = implode(', ', array_map(fn($p) => '$' . $p, $n['params']));
                $body = '';
                foreach ($n['body'] as $s) {
                    if ($s['type'] === 'Return') $body .= 'return ' . $this->expr($s['value']) . ';';
                    elseif ($s['type'] === 'ExprStmt') $body .= $this->expr($s['expr']) . ';';
                }
                return "function($params) { $body }";
            case 'New':
                $args = implode(', ', array_map(fn($a) => $this->expr($a), $n['args']));
                return 'new ' . $n['class'] . '(' . $args . ')';
            case 'MemberAccess':
                return '(' . $this->expr($n['target']) . ')->' . $n['name'];
            case 'MethodCall':
                $args = implode(', ', array_map(fn($a) => $this->expr($a), $n['args']));
                return '(' . $this->expr($n['target']) . ')->' . $n['method'] . '(' . $args . ')';
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
PHP
);

/* ============ ylpkg.php ============ */
w('ylpkg.php', <<<'PHP'
#!/usr/bin/env php
<?php
$root = getcwd();
$pkgDir = $root . '/yl_modules';
$manifest = $root . '/ylpkg.json';

$cmd = $argv[1] ?? 'help';

function readManifest(string $p): array {
    if (!is_file($p)) return ['name' => basename(dirname($p)), 'version' => '0.0.1', 'deps' => []];
    return json_decode((string)file_get_contents($p), true) ?? ['deps' => []];
}

switch ($cmd) {
    case 'init':
        if (is_file($manifest)) { echo "ylpkg.json уже существует\n"; exit(1); }
        file_put_contents($manifest, json_encode([
            'name' => basename($root), 'version' => '0.1.0',
            'deps' => new stdClass(),
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        @mkdir($pkgDir, 0777, true);
        echo "Инициализирован ylpkg.json\n";
        break;

    case 'install':
        $name = $argv[2] ?? null;
        if (!$name) { echo "Использование: php ylpkg.php install <url-или-путь>\n"; exit(1); }
        @mkdir($pkgDir, 0777, true);
        $target = $pkgDir . '/' . basename($name, '.yl');
        if (is_dir($name)) {
            @mkdir($target, 0777, true);
            foreach (glob("$name/*.yl") as $f) copy($f, $target . '/' . basename($f));
            echo "Установлен локальный пакет: $name → $target\n";
        } elseif (is_file($name)) {
            @mkdir($target, 0777, true);
            copy($name, $target . '/' . basename($name));
            echo "Установлен: $name → $target\n";
        } else {
            $data = @file_get_contents($name);
            if ($data === false) { echo "Не найдено: $name\n"; exit(1); }
            @mkdir($target, 0777, true);
            file_put_contents($target . '/' . basename($name, '.yl') . '.yl', $data);
            echo "Установлен из URL: $name\n";
        }
        $m = readManifest($manifest);
        $m['deps'][$name] = '*';
        file_put_contents($manifest, json_encode($m, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        break;

    case 'list':
        if (!is_dir($pkgDir)) { echo "Модулей нет\n"; break; }
        foreach (glob("$pkgDir/*") as $d) echo basename($d) . "\n";
        break;

    case 'help':
    default:
        echo "ylpkg — менеджер пакетов YL\n";
        echo "  init               — создать ylpkg.json\n";
        echo "  install <path|url> — установить пакет\n";
        echo "  list               — список установленных\n";
        break;
}
PHP
);

/* ============ playground/server.php ============ */
w('playground/server.php', <<<'PHP'
<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

$code = $_POST['code'] ?? '';
if ($code === '') { echo json_encode(['ok' => false, 'err' => 'Пустой код']); exit; }

$tmp = tempnam(sys_get_temp_dir(), 'yl_') . '.yl';
file_put_contents($tmp, $code);

$ylPath = __DIR__ . '/../yl.php';
$descriptor = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
$proc = proc_open(
    'php ' . escapeshellarg($ylPath) . ' --sandbox ' . escapeshellarg($tmp),
    $descriptor, $pipes
);
$out = stream_get_contents($pipes[1]);
$err = stream_get_contents($pipes[2]);
fclose($pipes[1]); fclose($pipes[2]);
$exit = proc_close($proc);
@unlink($tmp);

echo json_encode(['ok' => $exit === 0, 'out' => $out, 'err' => $err], JSON_UNESCAPED_UNICODE);
PHP
);

/* ============ playground/index.html ============ */
w('playground/index.html', <<<'HTML'
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<title>YL Playground</title>
<style>
    body { font-family: system-ui, sans-serif; background: #1a1a2e; color: #eee; margin: 0; padding: 20px; }
    h1 { color: #ffd369; font-size: 20px; }
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; height: 78vh; }
    textarea, pre {
        background: #16213e; color: #eee; border: 1px solid #0f3460; border-radius: 6px;
        padding: 12px; font: 14px ui-monospace, Consolas, monospace; height: 100%;
        resize: none; overflow: auto; white-space: pre-wrap; box-sizing: border-box;
    }
    textarea:focus { outline: 2px solid #ffd369; }
    button {
        background: #ffd369; color: #1a1a2e; border: none; padding: 10px 24px;
        font-weight: bold; border-radius: 4px; cursor: pointer; margin-top: 12px;
    }
    button:hover { background: #f9c74f; }
    .ok { color: #6ee7b7; }
    .err { color: #ef476f; }
</style>
</head>
<body>
    <h1>YL Playground — Yankee Language</h1>
    <div class="grid">
        <textarea id="code">~ Демо YL
¤ имя = "Мир"
» "Привет, " + имя + "!"

§ сумма(a) ⟦
    ¤ s = 0
    ⇶ x = a ⟦ s = s + x ⟧
    ^ s
⟧

» "Сумма:", сумма([1,2,3,4,5])

‡ Точка ⟦
    ⋔ init(x, y) ⟦ this.x = x; this.y = y ⟧
    ⋔ длина() ⟦ ^ sqrt(this.x * this.x + this.y * this.y) ⟧
⟧
¤ p = ⇢ Точка(3, 4)
» "Длина:", p.длина()</textarea>
        <pre id="out">Нажми «Запустить» →</pre>
    </div>
    <button onclick="run()">▶ Запустить</button>
<script>
async function run() {
    const code = document.getElementById('code').value;
    const out = document.getElementById('out');
    out.textContent = '...';
    try {
        const fd = new FormData();
        fd.append('code', code);
        const r = await fetch('server.php', { method: 'POST', body: fd });
        const j = await r.json();
        if (j.ok) { out.className = 'ok'; out.textContent = j.out || '(пусто)'; }
        else { out.className = 'err'; out.textContent = (j.out || '') + (j.err || 'ошибка'); }
    } catch (e) {
        out.className = 'err';
        out.textContent = 'Не удалось связаться с сервером: ' + e;
    }
}
</script>
</body>
</html>
HTML
);

/* ============ vscode-yl/ ============ */
w('vscode-yl/package.json', <<<'JSON'
{
    "name": "yl-language",
    "displayName": "YL (Yankee Language)",
    "version": "0.1.0",
    "engines": { "vscode": "^1.70.0" },
    "categories": ["Programming Languages"],
    "contributes": {
        "languages": [{
            "id": "yl",
            "aliases": ["YL", "yl"],
            "extensions": [".yl"],
            "configuration": "./language-configuration.json"
        }],
        "grammars": [{
            "language": "yl",
            "scopeName": "source.yl",
            "path": "./syntaxes/yl.tmLanguage.json"
        }],
        "snippets": [{
            "language": "yl",
            "path": "./snippets/yl.json"
        }]
    }
}
JSON
);

w('vscode-yl/language-configuration.json', <<<'JSON'
{
    "comments": { "lineComment": "~" },
    "brackets": [["⟦", "⟧"], ["[", "]"], ["(", ")"], ["⟪", "⟫"]],
    "autoClosingPairs": [
        { "open": "⟦", "close": "⟧" },
        { "open": "(", "close": ")" },
        { "open": "[", "close": "]" },
        { "open": "⟪", "close": "⟫" },
        { "open": "\"", "close": "\"" }
    ],
    "surroundingPairs": [
        ["⟦", "⟧"], ["(", ")"], ["[", "]"], ["⟪", "⟫"], ["\"", "\""]
    ]
}
JSON
);

w('vscode-yl/syntaxes/yl.tmLanguage.json', <<<'JSON'
{
    "$schema": "https://raw.githubusercontent.com/martinring/tmlanguage/master/tmlanguage.json",
    "name": "YL",
    "scopeName": "source.yl",
    "patterns": [
        { "include": "#comments" },
        { "include": "#strings" },
        { "include": "#keywords" },
        { "include": "#numbers" },
        { "include": "#functions" },
        { "include": "#operators" }
    ],
    "repository": {
        "comments": { "patterns": [{ "name": "comment.line.tilde.yl", "match": "~.*$" }] },
        "strings": { "patterns": [{
            "name": "string.quoted.double.yl",
            "begin": "\"", "end": "\"",
            "patterns": [{ "match": "\\\\.", "name": "constant.character.escape.yl" }]
        }] },
        "keywords": { "patterns": [{
            "name": "keyword.control.yl",
            "match": "[¤§λ»⟦⟧?¿@#^‼⁇⌦⊕⊘↻≡☑☐∅‡⋔⇢↤⇶†]"
        }] },
        "numbers": { "patterns": [{
            "name": "constant.numeric.yl",
            "match": "\\b\\d+(\\.\\d+)?\\b"
        }] },
        "functions": { "patterns": [
            { "name": "entity.name.function.yl", "match": "(?<=§\\s)[\\p{L}_][\\p{L}\\p{N}_]*" },
            { "name": "entity.name.type.yl", "match": "(?<=‡\\s)[\\p{L}_][\\p{L}\\p{N}_]*" }
        ] },
        "operators": { "patterns": [{
            "name": "keyword.operator.yl",
            "match": "==|!=|<=|>=|&&|\\|\\||\\.\\.|[+\\-*/%<>=!]"
        }] }
    }
}
JSON
);

w('vscode-yl/snippets/yl.json', <<<'JSON'
{
    "Функция": {
        "prefix": "fn",
        "body": ["§ ${1:имя}(${2:параметры}) ⟦", "\t$0", "⟧"]
    },
    "Объявление переменной": {
        "prefix": "decl",
        "body": "¤ ${1:имя} = ${2:значение}"
    },
    "Печать": {
        "prefix": "print",
        "body": "» $1"
    },
    "If": {
        "prefix": "if",
        "body": ["? ${1:условие} ⟦", "\t$2", "⟧ ¿ ⟦", "\t$3", "⟧"]
    },
    "While": {
        "prefix": "while",
        "body": ["@ ${1:условие} ⟦", "\t$2", "⟧"]
    },
    "Класс": {
        "prefix": "class",
        "body": ["‡ ${1:Имя} ⟦", "\t⋔ init(${2:параметры}) ⟦", "\t\t$0", "\t⟧", "⟧"]
    }
}
JSON
);

/* ============ ПАТЧ yl.php: чиним REPL ============ */
echo "\nПатч yl.php (REPL)...\n";
$ylPath = $base . '/yl.php';
if (!is_file($ylPath)) {
    echo "  ! yl.php не найден — пропускаю патч\n";
} else {
    $yl = (string)file_get_contents($ylPath);
    if (strpos($yl, 'REPL-FIXED-V3') !== false) {
        echo "  = REPL уже пропатчен\n";
    } else {
        $newRepl = <<<'PHPCODE'
function repl(): void {
    // REPL-FIXED-V3
    echo "YL REPL v3. Команда 'выход' (или exit, quit, :q) для выхода.\n";
    $interp = new Interpreter();
    $prel = __DIR__ . '/std/prelude.yl';
    if (is_file($prel)) {
        try {
            $src = (string)file_get_contents($prel);
            $ast = (new Parser((new Lexer($src))->tokenize()))->parse();
            $interp->runProgram($ast);
        } catch (Throwable $e) { fwrite(STDERR, "prelude: " . $e->getMessage() . "\n"); }
    }
    $buffer = '';
    while (true) {
        fwrite(STDOUT, $buffer === '' ? "yl> " : "..> ");
        $line = fgets(STDIN);
        if ($line === false) { echo "\n"; break; }
        $line = preg_replace('/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $line);
        $trim = trim($line);
        if ($trim === '') continue;
        if (in_array($trim, ['выход', 'exit', 'quit', ':q'], true)) break;
        $buffer .= $line;
        $open = substr_count($buffer, Sym::$m['open']);
        $close = substr_count($buffer, Sym::$m['close']);
        if ($open > $close) continue;
        try {
            $ast = (new Parser((new Lexer($buffer))->tokenize()))->parse();
            $interp->runProgram($ast);
        } catch (Throwable $e) {
            fwrite(STDERR, "! " . $e->getMessage() . "\n");
        }
        $buffer = '';
    }
}
PHPCODE;
        $patched = preg_replace('/function repl\(\): void \{.*?\n\}/s', $newRepl, $yl, 1);
        if ($patched !== null && $patched !== $yl) {
            file_put_contents($ylPath, $patched);
            echo "  ✓ repl() обновлён\n";
        } else {
            echo "  ! не удалось найти repl() — пропускаю\n";
        }
    }
}

/* ============ КОМАНДА CHECK ============ */
echo "\nПроверка структуры:\n";
$must = [
    'yl.php','ylc.php','ylpkg.php',
    'std/prelude.yl','std/math.yl','std/list.yl','std/string.yl',
    'examples/main.yl','examples/oop.yl','examples/async.yl',
    'playground/server.php','playground/index.html',
    'vscode-yl/package.json','vscode-yl/syntaxes/yl.tmLanguage.json',
];
foreach ($must as $f) {
    $p = $base . '/' . $f;
    echo (is_file($p) ? "  ✓ " : "  ✗ ") . $f . "\n";
}

echo "\nГотово! Что запустить:\n";
echo "  php yl.php examples/main.yl\n";
echo "  php yl.php examples/oop.yl\n";
echo "  php yl.php examples/async.yl\n";
echo "  php yl.php --repl        (выход: 'выход' или 'exit')\n";
echo "  php ylc.php examples/main.yl main_compiled.php\n";
echo "  php main_compiled.php\n";
echo "  php ylpkg.php init\n";
echo "  cd playground && php -S localhost:8080\n";