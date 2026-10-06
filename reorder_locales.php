<?php
declare(strict_types=1);
$path = __DIR__ . '/docs/.vitepress/config.mts';
$cfg = (string)file_get_contents($path);
copy($path, $path . '.bak-' . date('Ymd-His'));

/**
 * Находит блок `key: mk({ ... }),` в тексте.
 * Возвращает [start, end, block] где block содержит ведущий \n.
 */
function findLocaleBlock(string $s, string $key): ?array {
    if ($key === 'root') {
        $pattern = '/(\n\s*root:\s*mk\(\{)/';
    } elseif (strpos($key, '-') !== false) {
        $pattern = '/(\n\s*\'' . preg_quote($key, '/') . '\':\s*mk\(\{)/';
    } else {
        $pattern = '/(\n\s*' . preg_quote($key, '/') . ':\s*mk\(\{)/';
    }
    if (!preg_match($pattern, $s, $m, PREG_OFFSET_CAPTURE)) return null;

    $matchStart = $m[1][1];
    $braceOpen  = strpos($s, '{', $matchStart);
    $depth = 0; $i = $braceOpen; $len = strlen($s); $inStr = null;

    while ($i < $len) {
        $c = $s[$i];
        if ($inStr !== null) {
            if ($c === '\\') { $i += 2; continue; }
            if ($c === $inStr) $inStr = null;
            $i++; continue;
        }
        if ($c === '"' || $c === "'" || $c === '`') { $inStr = $c; }
        elseif ($c === '{') $depth++;
        elseif ($c === '}') {
            $depth--;
            if ($depth === 0) {
                $j = $i + 1;
                if ($j < $len && $s[$j] === ',') $j++;
                return [
                    'start' => $matchStart,
                    'end'   => $j,
                    'block' => substr($s, $matchStart, $j - $matchStart),
                ];
            }
        }
        $i++;
    }
    return null;
}

// === Проверка текущего порядка ===
echo "Текущий порядок локалей:\n";
preg_match_all('/\n\s*(?:root|(\'?[a-zA-Z-]+\'?)):\s*mk\(/m', $cfg, $all);
foreach ($all[0] as $m) {
    echo "  " . trim($m) . "\n";
}

// === 1. Находим блок ar ===
$ar = findLocaleBlock($cfg, 'ar');
if (!$ar) { fwrite(STDERR, "! ar не найден\n"); exit(1); }
$arClean = ltrim($ar['block'], "\n");

// === 2. Удаляем ar с его места ===
$cfg = substr($cfg, 0, $ar['start']) . substr($cfg, $ar['end']);

// === 3. Находим блок en в новом тексте ===
$en = findLocaleBlock($cfg, 'en');
if (!$en) { fwrite(STDERR, "! en не найден\n"); exit(1); }

// === 4. Вставляем ar сразу после en ===
$cfg = substr($cfg, 0, $en['end'])
     . "\n\n"
     . $arClean
     . substr($cfg, $en['end']);

file_put_contents($path, $cfg);
echo "\nOK: ar перемещён после en\n\n";

// === Проверка результата ===
$cfg = file_get_contents($path);
echo "Новый порядок локалей:\n";
preg_match_all('/\n\s*(?:root|(\'?[a-zA-Z-]+\'?)):\s*mk\(/m', $cfg, $all);
foreach ($all[0] as $m) {
    echo "  " . trim($m) . "\n";
}

echo "\nДальше:\n";
echo "  npm run docs:build\n";
echo "  git add .\n";
echo "  git commit -m \"Reorder locales: ar right after en\"\n";
echo "  git push\n";