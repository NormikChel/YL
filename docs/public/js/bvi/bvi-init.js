// YL BVI v2 — надёжная интеграция
(function () {
  'use strict';

  var bviInstance = null;
  var buttonInserted = false;

  function insertButton() {
    var nav = document.querySelector('.VPNavBar .content-body');
    if (!nav) return false;

    // Уже есть?
    var existing = nav.querySelector('.bvi-open');
    if (existing) { buttonInserted = true; return true; }

    var btn = document.createElement('a');
    btn.href = '#';
    btn.className = 'bvi-open';
    btn.setAttribute('aria-label', 'Версия для слабовидящих');
    btn.setAttribute('title', 'Версия для слабовидящих');
    btn.style.cssText =
      'display:inline-flex;align-items:center;justify-content:center;' +
      'width:36px;height:36px;margin-right:8px;border-radius:8px;' +
      'text-decoration:none;font-size:18px;line-height:1;' +
      'color:var(--vp-c-text-1);transition:background-color .2s;';
    btn.textContent = '👁';

    var anchor = nav.querySelector('.VPNavBarAppearance')
              || nav.querySelector('.VPNavBarSocialLinks');
    if (anchor) nav.insertBefore(btn, anchor);
    else nav.appendChild(btn);

    buttonInserted = true;
    console.info('[YL BVI] button inserted');
    return true;
  }

  function ensureBviBound() {
    // Библиотека BVI экспортирует конструктор в window.Bvi.
    // Каждый new Bvi() навешивает click на все .bvi-open.
    if (typeof window.Bvi !== 'function') return;
    if (!buttonInserted) return;
    try {
      // Пересоздаём — не страшно, BVI идемпотентен на повторный init
      bviInstance = new window.Bvi({
        // Настройки как в демо библиотеки:
        bviPanelBg: '#ffffff',
        bviPanelFontSize: 16,
        bviPanelLetterSpacing: 0,
        bviPanelLineHeight: 1.5,
        bviPanelImg: true,
        bviPanelImgHeight: 50,
      });
    } catch (e) {
      console.warn('[YL BVI] init warning:', e);
    }
  }

  // Ждём полной гидратации Vue: mutationObserver ловит момент,
  // когда .VPNavBar .content-body реально появляется в DOM
  var observer = new MutationObserver(function () {
    if (document.querySelector('.VPNavBar .content-body')) {
      if (insertButton()) {
        ensureBviBound();
      }
    }
  });
  observer.observe(document.documentElement, { childList: true, subtree: true });

  // Пробуем сразу тоже (вдруг навбар уже есть)
  function boot() {
    if (insertButton()) ensureBviBound();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  // После SPA-перехода VitePress пересобирает навбар — вставляем заново
  window.addEventListener('vitepress:routeChanged', function () {
    buttonInserted = false;
    setTimeout(function () {
      if (insertButton()) ensureBviBound();
    }, 50);
  });
})();