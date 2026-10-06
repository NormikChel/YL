// YL Lenis init
(function () {
  if (typeof Lenis === 'undefined') { console.warn('[YL] no Lenis'); return; }

  // Убираем нативный smooth-scroll inline-стилем
  try {
    document.documentElement.style.scrollBehavior = 'auto';
    document.body.style.scrollBehavior = 'auto';
  } catch (e) {}

  // Отключаем scroll restoration браузера — чтобы VitePress/SPA не сбрасывал position
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }

  var lenis = new Lenis({
    autoRaf: true,

    // ──────── ГЛАВНОЕ: очень мягкий lerp ────────
    // Чем меньше — тем дольше едет после колеса.
    // 0.05 — плавно и заметно
    // 0.03 — очень плавно
    // 0.02 — почти желе
    // 0.01 — почти не останавливается
    lerp: 0.02,

    // ──────── Слабый multiplier — колесо двигает мало ────────
    // 1 = стандарт. 0.5 = вдвое медленнее, плавнее, заметнее.
    wheelMultiplier: 0.5,
    touchMultiplier: 0.8,

    smoothWheel: true,
    syncTouch: false,

    // ──────── Отключаем duration-режим ────────
    // Если duration задан — lerp игнорируется. Оставляем undefined.
    // duration: undefined,

    easing: function (x) { return Math.min(1, 1.001 - Math.pow(2, -10 * x)); },

    // ──────── Не пропускаем через себя скроллбары и оверлеи ────────
    prevent: function (node) {
      return node.hasAttribute && node.hasAttribute('data-lenis-prevent');
    },
  });

  window.lenisInstance = lenis;

  // Диагностика — раскомментируй, чтобы видеть, что происходит
  // lenis.on('scroll', function (e) {
  //   console.log('progress:', e.progress.toFixed(3),
  //               'velocity:', e.velocity.toFixed(2),
  //               'isScrolling:', lenis.isScrolling);
  // });

  console.info('[YL] Lenis ready', {
    lerp: lenis.options.lerp,
    wheelMultiplier: lenis.options.wheelMultiplier
  });
})();