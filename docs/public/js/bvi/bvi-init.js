// YL BVI — инициализация как на bvi.isvek.ru (namespace `isvek`)
(function () {
  function boot() {
    // Библиотека bvi.min.js создаёт глобальный namespace `isvek`
    if (typeof window.isvek !== 'object' || typeof window.isvek.Bvi !== 'function') {
      console.warn('[YL BVI] isvek.Bvi not found. Проверь загрузку bvi.min.js и jQuery');
      return;
    }
    try {
      new window.isvek.Bvi({
        target: '.bvi-open',      // кнопка-триггер (класс)
        theme: 'white',           // white|black|blue|brown|green
        font: 'arial',            // arial|times
        fontSize: 16,
        letterSpacing: 'normal',  // normal|average|big
        lineHeight: 'normal',     // normal|average|big
        images: 'grayscale',      // true|false|grayscale
        speech: true,             // синтез речи
        builtElements: true,      // видео, iframe
        hide: false,              // true — только иконка
      });
      console.info('[YL BVI] initialized (isvek.Bvi)');
    } catch (e) {
      console.error('[YL BVI] init failed:', e);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();