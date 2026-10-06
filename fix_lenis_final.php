<?php
declare(strict_types=1);
$BASE = __DIR__ . '/docs/.vitepress/theme';

/* ---------- 1. Новый lenis-init.ts с observer ---------- */
$code = <<<'TS'
// YL Lenis — работает даже когда VitePress/Vue стирает className
import './lenis.min.js'

let lenis: any = null

function ensureLenisClasses() {
  if (typeof document === 'undefined') return
  const html = document.documentElement
  html.classList.add('lenis')
  if (lenis?.isScrolling === 'smooth') html.classList.add('lenis-smooth')
  else if (lenis?.isScrolling === 'native') html.classList.add('lenis-smooth')
}

function initLenis() {
  if (lenis) return
  if (typeof window === 'undefined') return

  const LenisCtor = (window as any).Lenis
  if (typeof LenisCtor !== 'function') {
    console.warn('[YL] Lenis ctor not found')
    return
  }

  // Принудительно убираем нативный smooth
  document.documentElement.style.scrollBehavior = 'auto'
  document.body.style.scrollBehavior = 'auto'

  lenis = new LenisCtor({
    autoRaf: true,
    lerp: 0.1,
    duration: 1.2,
    wheelMultiplier: 1,
    touchMultiplier: 1,
    smoothWheel: true,
    syncTouch: false,
    easing: (x: number) => Math.min(1, 1.001 - Math.pow(2, -10 * x)),
  })

  ;(window as any).lenisInstance = lenis

  // Кидаем классы сразу
  ensureLenisClasses()

  // Lenis вызывает updateClassName в своём rAF — ловим и дублируем
  lenis.on('scroll', ensureLenisClasses)

  // MutationObserver: если VitePress стёр className — сразу возвращаем
  const obs = new MutationObserver(() => {
    const html = document.documentElement
    if (!html.classList.contains('lenis')) {
      html.classList.add('lenis')
    }
    if ((lenis?.isScrolling === 'smooth' || lenis?.isScrolling === 'native')
        && !html.classList.contains('lenis-smooth')) {
      html.classList.add('lenis-smooth')
    }
  })
  obs.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class'],
  })

  console.info('[YL Lenis] ready', {
    lerp: 0.1,
    wheelMultiplier: 1,
    classes: document.documentElement.className,
  })
}

if (typeof window !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLenis)
  } else {
    initLenis()
  }
}

export {}
TS;

file_put_contents($BASE . '/lenis-init.ts', $code);
echo "  + lenis-init.ts перезаписан (с MutationObserver)\n";

/* ---------- 2. Проверяем index.ts ---------- */
$index = $BASE . '/index.ts';
$idx = (string)file_get_contents($index);
if (strpos($idx, "import './lenis-init'") === false) {
    // убираем старые импорты lenis
    $idx = preg_replace("/import '\.\/lenis[^']*'\n?/", '', $idx);
    // добавляем перед последней строкой
    $idx = preg_replace(
        "/(import '\.\/custom-scrollbar\.css'\n)/",
        "$1import './lenis-init'\n",
        $idx
    );
    file_put_contents($index, $idx);
    echo "  + index.ts: import './lenis-init' добавлен\n";
} else {
    echo "  = index.ts: import уже есть\n";
}

/* ---------- 3. lenis.min.js должен быть ---------- */
$lenisPath = $BASE . '/lenis.min.js';
if (!is_file($lenisPath)) {
    // пытаемся найти в node_modules
    $src = __DIR__ . '/node_modules/lenis/dist/lenis.min.js';
    if (is_file($src)) {
        copy($src, $lenisPath);
        echo "  + lenis.min.js скопирован из node_modules\n";
    } else {
        echo "  ! lenis.min.js не найден — положи его в theme/ вручную\n";
    }
} else {
    echo "  = lenis.min.js уже есть (" . filesize($lenisPath) . " b)\n";
}

/* ---------- 4. Жёсткий CSS ---------- */
$cssFile = $BASE . '/custom.css';
$css = is_file($cssFile) ? (string)file_get_contents($cssFile) : '';
if (strpos($css, '/* YL-LENIS-FORCE */') === false) {
    $css .= "\n\n/* YL-LENIS-FORCE */\n";
    $css .= "html, html.lenis, html.lenis-smooth, html.lenis-smooth body,\n";
    $css .= "body { scroll-behavior: auto !important; }\n";
    $css .= "html.lenis body { height: auto; }\n";
    $css .= ".lenis.lenis-stopped { overflow: hidden; }\n";
    file_put_contents($cssFile, $css);
    echo "  + custom.css: LENIS-FORCE правила\n";
} else {
    echo "  = custom.css: LENIS-FORCE уже есть\n";
}

echo "\n=== Дальше ===\n";
echo "  1. Ctrl+C в окне VitePress\n";
echo "  2. npm run docs:dev\n";
echo "  3. Ctrl+Shift+R\n";
echo "  4. Открой консоль — должно быть:\n";
echo "     [YL Lenis] ready { ... classes: 'dark lenis lenis-smooth' }\n";