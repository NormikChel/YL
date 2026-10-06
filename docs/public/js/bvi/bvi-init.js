// YL BVI — кнопка для слабовидящих.
// Библиотека BVI сама навешивает обработчик на .bvi-open.
// Мы только вставляем кнопку в навбар VitePress.

(function () {
  'use strict';

  function insertButton() {
    var nav = document.querySelector('.VPNavBar .content-body');
    if (!nav) return false;
    if (nav.querySelector('.bvi-open')) return true;

    var btn = document.createElement('a');
    btn.href = '#';
    btn.className = 'bvi-open';   // <-- именно этот класс слушает библиотека
    btn.setAttribute('aria-label', 'Версия для слабовидящих');
    btn.setAttribute('title', 'Версия для слабовидящих');
    btn.style.cssText = 'display:inline-flex;align-items:center;justify-content:center;'
                      + 'width:36px;height:36px;margin-right:8px;border-radius:8px;'
                      + 'text-decoration:none;font-size:18px;line-height:1;'
                      + 'color:var(--vp-c-text-1);transition:background-color .2s;';
    btn.textContent = '👁';

    // Вставляем ПЕРЕД тумблером темы, если он есть
    var anchor = nav.querySelector('.VPNavBarAppearance')
              || nav.querySelector('.VPNavBarSocialLinks');
    if (anchor) nav.insertBefore(btn, anchor);
    else nav.appendChild(btn);

    console.info('[YL BVI] button inserted');
    return true;
  }

  var attempts = 0;
  function tryInsert() {
    if (insertButton()) return;
    if (++attempts < 100) setTimeout(tryInsert, 100);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', tryInsert);
  } else {
    tryInsert();
  }

  // VitePress пересобирает навбар при SPA-переходах
  window.addEventListener('vitepress:routeChanged', function () {
    attempts = 0;
    tryInsert();
  });
})();