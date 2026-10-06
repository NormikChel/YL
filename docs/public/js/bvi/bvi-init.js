// BVI: просто инициализация. Кнопку библиотека создаёт сама.
(function () {
  function boot() {
    if (typeof window.Bvi !== 'function') {
      console.warn('[YL BVI] Bvi not found');
      return;
    }
    try {
      new window.Bvi();
      console.info('[YL BVI] initialized');
    } catch (e) {
      console.error('[YL BVI] failed:', e);
    }
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();