// scripts/gen-feeds.mjs — генерирует rss.xml и atom.xml из собранного dist
// Запускается после `vitepress build`. См. postdocs:build в package.json.
import { readFileSync, writeFileSync, statSync, existsSync, readdirSync } from 'node:fs';
import { join, relative, sep } from 'node:path';
import { fileURLToPath } from 'node:url';
import { dirname } from 'node:path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const SITE = 'https://yankeelanguage.vercel.app';
const TITLE = 'YL - Yankee Language';
const DESC = 'Esoteric programming language on PHP with unicode syntax';
const AUTHOR = 'NormikChel';
const GH = 'https://github.com/NormikChel';

const ROOT = join(__dirname, '..');
const DIST = join(ROOT, 'docs', '.vitepress', 'dist');

if (!existsSync(DIST)) {
  console.error(`dist не найден: ${DIST}. Сначала запусти 'npm run docs:build'.`);
  process.exit(1);
}

/** Рекурсивный обход */
function walk(dir) {
  const out = [];
  for (const name of readdirSync(dir)) {
    const p = join(dir, name);
    const st = statSync(p);
    if (st.isDirectory()) out.push(...walk(p));
    else out.push(p);
  }
  return out;
}

/** Парсим .md — заголовок и описание */
function parseMd(src, fallback) {
  let title = null;
  let desc = null;
  const m1 = src.match(/^#\s+(.+)$/m);
  if (m1) title = m1[1].trim();
  const m2 = src.match(/^>\s*(.+)$/m);
  if (m2) desc = m2[1].trim();
  if (!desc) {
    const lines = src.split(/\r?\n/);
    for (const raw of lines) {
      const l = raw.trim();
      if (!l) continue;
      if ('#>`-'.includes(l[0])) continue;
      desc = l.slice(0, 160);
      break;
    }
  }
  return [title || fallback.replace(/\.md$/, ''), desc || 'YL documentation'];
}

const roots = {
  '': join(ROOT, 'docs'),
  'en': join(ROOT, 'docs', 'en'),
  'zh-Hans': join(ROOT, 'docs', 'zh-Hans'),
  'zh-Hant': join(ROOT, 'docs', 'zh-Hant'),
};

const entries = [];

for (const [prefix, root] of Object.entries(roots)) {
  if (!existsSync(root)) continue;
  for (const file of walk(root)) {
    if (!file.endsWith('.md')) continue;
    if (file.includes(`${sep}.vitepress${sep}`)) continue;
    const base = file.split(sep).pop();
    if (base === 'index.md') continue;

    const rel = relative(root, file).split(sep).join('/').replace(/\.md$/, '');
    const path = prefix === '' ? `/${rel}` : `/${prefix}/${rel}`;
    const url = SITE + path;

    const content = readFileSync(file, 'utf8');
    const [title, desc] = parseMd(content, base);
    const date = statSync(file).mtime;

    entries.push({
      url,
      title,
      desc,
      date,
      lang: prefix === '' ? 'ru' : prefix,
    });
  }
}

entries.sort((a, b) => b.date - a.date);

function xmlesc(s) {
  return String(s)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&apos;');
}

function rfc822(d) {
  return d.toUTCString().replace(/GMT$/, 'GMT');
}

function iso8601(d) {
  return d.toISOString().replace(/\.\d+Z$/, 'Z');
}

const now = new Date();

/* ---------- RSS 2.0 ---------- */
let rss = '<?xml version="1.0" encoding="UTF-8"?>\n';
rss += '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/">\n';
rss += '  <channel>\n';
rss += `    <title>${xmlesc(TITLE)}</title>\n`;
rss += `    <link>${SITE}/</link>\n`;
rss += `    <description>${xmlesc(DESC)}</description>\n`;
rss += '    <language>ru</language>\n';
rss += `    <lastBuildDate>${rfc822(now)}</lastBuildDate>\n`;
rss += `    <atom:link href="${SITE}/rss.xml" rel="self" type="application/rss+xml"/>\n`;
for (const e of entries) {
  rss += '    <item>\n';
  rss += `      <title>${xmlesc(e.title)}</title>\n`;
  rss += `      <link>${e.url}</link>\n`;
  rss += `      <guid isPermaLink="true">${e.url}</guid>\n`;
  rss += `      <description>${xmlesc(e.desc)}</description>\n`;
  rss += `      <pubDate>${rfc822(e.date)}</pubDate>\n`;
  rss += `      <dc:creator>${xmlesc(AUTHOR)}</dc:creator>\n`;
  rss += `      <language>${e.lang}</language>\n`;
  rss += '    </item>\n';
}
rss += '  </channel>\n</rss>\n';

/* ---------- Atom 1.0 ---------- */
let atom = '<?xml version="1.0" encoding="UTF-8"?>\n';
atom += '<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="ru">\n';
atom += `  <title>${xmlesc(TITLE)}</title>\n`;
atom += `  <subtitle>${xmlesc(DESC)}</subtitle>\n`;
atom += `  <link href="${SITE}/atom.xml" rel="self" type="application/atom+xml"/>\n`;
atom += `  <link href="${SITE}/" rel="alternate" type="text/html"/>\n`;
atom += `  <updated>${iso8601(now)}</updated>\n`;
atom += `  <id>${SITE}/</id>\n`;
atom += '  <author>\n';
atom += `    <name>${xmlesc(AUTHOR)}</name>\n`;
atom += `    <uri>${GH}</uri>\n`;
atom += '  </author>\n';
for (const e of entries) {
  atom += '  <entry>\n';
  atom += `    <title>${xmlesc(e.title)}</title>\n`;
  atom += `    <link href="${e.url}" rel="alternate" type="text/html"/>\n`;
  atom += `    <id>${e.url}</id>\n`;
  atom += `    <updated>${iso8601(e.date)}</updated>\n`;
  atom += `    <summary>${xmlesc(e.desc)}</summary>\n`;
  atom += '  </entry>\n';
}
atom += '</feed>\n';

writeFileSync(join(DIST, 'rss.xml'), rss);
writeFileSync(join(DIST, 'atom.xml'), atom);

console.log(`OK: rss.xml (${rss.length} b), atom.xml (${atom.length} b), записей: ${entries.length}`);