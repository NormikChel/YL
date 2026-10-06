<?php
declare(strict_types=1);
$BASE = __DIR__;
$USER = 'NormikChel';
$REPO = 'YL';

function walk(string $dir, callable $fn): void {
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
        if ($f->isFile()) $fn($f->getPathname());
    }
}

$count = 0;
$patterns = [
    'github.com/your/yl' => "github.com/$USER/$REPO",
    'github.com/YOU/yl' => "github.com/$USER/$REPO",
];

// Обрабатываем config.mts, все .md в docs/
walk($BASE . '/docs', function ($path) use (&$count, $patterns, $BASE) {
    if (!preg_match('/\.(md|mts|ts|json|yml|yaml)$/i', $path)) return;
    $s = (string)file_get_contents($path);
    $new = $s;
    foreach ($patterns as $from => $to) {
        $new = str_replace($from, $to, $new);
    }
    if ($new !== $s) {
        file_put_contents($path, $new);
        echo "  ~ " . str_replace($BASE . '/', '', $path) . "\n";
        $count++;
    }
});

// README.md, package.json, composer.json в корне
foreach (['README.md', 'package.json', 'composer.json', 'vercel.json'] as $f) {
    $path = $BASE . '/' . $f;
    if (!is_file($path)) continue;
    $s = (string)file_get_contents($path);
    $new = $s;
    foreach ($patterns as $from => $to) {
        $new = str_replace($from, $to, $new);
    }
    if ($new !== $s) {
        file_put_contents($path, $new);
        echo "  ~ $f\n";
        $count++;
    }
}

echo "\nГотово: обновлено $count файлов\n";
echo "Проверка:\n";
echo "  grep -r 'github.com/your' docs/ README.md 2>/dev/null   (должно быть пусто)\n";