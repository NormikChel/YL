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