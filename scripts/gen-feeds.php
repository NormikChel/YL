<?php
/**
 * scripts/gen-feeds.php — генерирует rss.xml и atom.xml из docs/*.md
 * Запускается после `vitepress build`. См. postbuild в package.json.
 */
declare(strict_types=1);

$SITE = 'https://yankeelanguage.vercel.app';
$TITLE = 'YL - Yankee Language';
$DESC = 'Esoteric programming language on PHP with unicode syntax';
$AUTHOR = 'NormikChel';
$BASE = dirname(__DIR__);
$DIST = $BASE . '/docs/.vitepress/dist';

if (!is_dir($DIST)) {
    fwrite(STDERR, "dist не найден: $DIST. Сначала запусти `npm run docs:build`.\n");
    exit(1);
}

$entries = [];

/**
 * Обходим docs/*.md + docs/{en,zh-Hans,zh-Hant}/*.md
 * Превращаем путь в URL по правилам VitePress cleanUrls.
 */
$roots = [
    '' => $BASE . '/docs',
    'en' => $BASE . '/docs/en',
    'zh-Hans' => $BASE . '/docs/zh-Hans',
    'zh-Hant' => $BASE . '/docs/zh-Hant',
];

foreach ($roots as $prefix => $root) {
    if (!is_dir($root)) continue;
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($it as $f) {
        if (!$f->isFile()) continue;
        $name = $f->getFilename();
        if (!preg_match('/\.md$/', $name)) continue;
        if ($name === 'index.md') continue;              // index → корень раздела
        if (preg_match('#/\.vitepress/#', $f->getPathname())) continue;

        $rel = str_replace($root . DIRECTORY_SEPARATOR, '', $f->getPathname());
        $rel = str_replace('\\', '/', $rel);
        $rel = preg_replace('/\.md$/', '', $rel);
        // /guide/getting-started.md → /guide/getting-started
        $slug = $rel;
        $path = $prefix === '' ? "/$slug" : "/$prefix/$slug";
        $url = $SITE . $path;

        $content = (string)file_get_contents($f->getPathname());
        [$title, $desc] = parseMd($content, $name);

        $entries[] = [
            'url' => $url,
            'title' => $title,
            'desc' => $desc,
            'date' => filemtime($f->getPathname()),
            'lang' => $prefix === '' ? 'ru' : $prefix,
        ];
    }
}

usort($entries, fn($a, $b) => $b['date'] <=> $a['date']);

function parseMd(string $src, string $fallback): array {
    $title = null;
    $desc = null;
    if (preg_match('/^#\s+(.+)$/m', $src, $m)) $title = trim($m[1]);
    if (preg_match('/^>\s*(.+)$/m', $src, $m)) $desc = trim($m[1]);
    if (!$desc) {
        // первая обычная строка после заголовка
        $lines = preg_split('/\r?\n/', $src);
        foreach ($lines as $l) {
            $l = trim($l);
            if ($l === '' || $l[0] === '#' || $l[0] === '>' || $l[0] === '`' || $l[0] === '-') continue;
            $desc = mb_substr($l, 0, 160);
            break;
        }
    }
    return [$title ?: preg_replace('/\.md$/', '', $fallback), $desc ?: 'YL documentation'];
}

$now = date('D, d M Y H:i:s \G\M\T');

/* ---------- RSS 2.0 ---------- */
$rss  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$rss .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">' . "\n";
$rss .= "  <channel>\n";
$rss .= '    <title>' . htmlspecialchars($TITLE) . "</title>\n";
$rss .= '    <link>' . $SITE . "/</link>\n";
$rss .= '    <description>' . htmlspecialchars($DESC) . "</description>\n";
$rss .= "    <language>ru</language>\n";
$rss .= '    <lastBuildDate>' . $now . "</lastBuildDate>\n";
$rss .= '    <atom:link href="' . $SITE . '/rss.xml" rel="self" type="application/rss+xml"/>' . "\n";
foreach ($entries as $e) {
    $rss .= "    <item>\n";
    $rss .= '      <title>' . htmlspecialchars($e['title']) . "</title>\n";
    $rss .= '      <link>' . $e['url'] . "</link>\n";
    $rss .= '      <guid isPermaLink="true">' . $e['url'] . "</guid>\n";
    $rss .= '      <description>' . htmlspecialchars($e['desc']) . "</description>\n";
    $rss .= '      <pubDate>' . date('D, d M Y H:i:s \G\M\T', $e['date']) . "</pubDate>\n";
    $rss .= '      <dc:creator>' . htmlspecialchars($AUTHOR) . "</dc:creator>\n";
    $rss .= '      <language>' . $e['lang'] . "</language>\n";
    $rss .= "    </item>\n";
}
$rss .= "  </channel>\n</rss>\n";

/* ---------- Atom 1.0 ---------- */
$atom  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$atom .= '<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="ru">' . "\n";
$atom .= '  <title>' . htmlspecialchars($TITLE) . "</title>\n";
$atom .= '  <subtitle>' . htmlspecialchars($DESC) . "</subtitle>\n";
$atom .= '  <link href="' . $SITE . '/atom.xml" rel="self" type="application/atom+xml"/>' . "\n";
$atom .= '  <link href="' . $SITE . '/" rel="alternate" type="text/html"/>' . "\n";
$atom .= '  <updated>' . gmdate('Y-m-d\TH:i:s\Z') . "</updated>\n";
$atom .= '  <id>' . $SITE . "/</id>\n";
$atom .= "  <author>\n";
$atom .= '    <name>' . htmlspecialchars($AUTHOR) . "</name>\n";
$atom .= '    <uri>https://github.com/NormikChel</uri>' . "\n";
$atom .= "  </author>\n";
foreach ($entries as $e) {
    $atom .= "  <entry>\n";
    $atom .= '    <title>' . htmlspecialchars($e['title']) . "</title>\n";
    $atom .= '    <link href="' . $e['url'] . '" rel="alternate" type="text/html"/>' . "\n";
    $atom .= '    <id>' . $e['url'] . "</id>\n";
    $atom .= '    <updated>' . gmdate('Y-m-d\TH:i:s\Z', $e['date']) . "</updated>\n";
    $atom .= '    <summary>' . htmlspecialchars($e['desc']) . "</summary>\n";
    $atom .= "  </entry>\n";
}
$atom .= "</feed>\n";

file_put_contents($DIST . '/rss.xml', $rss);
file_put_contents($DIST . '/atom.xml', $atom);
echo "OK: rss.xml (" . strlen($rss) . " b), atom.xml (" . strlen($atom) . " b), записей: " . count($entries) . "\n";