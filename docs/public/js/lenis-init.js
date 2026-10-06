// YL Lenis init — загружается как обычный <script> из /public/js
(function () {
  if (typeof Lenis === 'undefined') {
    console.warn('[YL] Lenis not loaded');
    return;
  }
  // Убиваем нативный smooth inline-стилем (бьёт любой CSS)
  try {
    document.documentElement.style.scrollBehavior = 'auto';
    document.body.style.scrollBehavior = 'auto';
  } catch (e) {}
  window.lenisInstance = new Lenis({
    autoRaf: true,
    lerp: 0.1,
    duration: 1.2,
    wheelMultiplier: 1,
    touchMultiplier: 1,
    smoothWheel: true,
    syncTouch: false,
    easing: function (x) { return Math.min(1, 1.001 - Math.pow(2, -10 * x)); }
  });
  console.info('[YL] Lenis ready');
})();