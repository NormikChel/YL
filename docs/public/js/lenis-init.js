// YL Smooth scroll — точно как на bulbaslandia.onrender.com
// Загружается в конце <body> как обычный <script>, без ES modules.

(function () {
  if (typeof Lenis === 'undefined') {
    console.warn('[YL] Lenis not loaded');
    return;
  }

  // Убираем нативный smooth, который может конфликтовать
  document.documentElement.style.scrollBehavior = 'auto';
  document.body.style.scrollBehavior = 'auto';

  var lenis = new Lenis({
    autoRaf: true,
    lerp: 0.1,
    duration: 1.2,
    wheelMultiplier: 1,
    touchMultiplier: 1,
    smoothWheel: true,
    syncTouch: false,
    easing: function (x) { return Math.min(1, 1.001 - Math.pow(2, -10 * x)); }
  });

  window.lenisInstance = lenis;

  console.info('[YL Lenis] initialized (global script)', {
    lerp: 0.1,
    autoRaf: true,
    wheelMultiplier: 1
  });
})();