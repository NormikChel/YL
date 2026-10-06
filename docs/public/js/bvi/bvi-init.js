// YL BVI — button for visually impaired users
// Вставляет кнопку 👁 в навбар VitePress и инициализирует BVI
(function () {
  'use strict';

  var MAX_ATTEMPTS = 50;
  var attempts = 0;

  function findNavTarget() {
    // Ищем блок кнопок в навбаре — вставляем ПЕРЕД тумблером темы
    return document.querySelector('.VPNavBar .content-body');
  }

  function insertButton() {
    var nav = findNavTarget();
    if (!nav) return false;

    // Уже есть?
    if (nav.querySelector('.bvi-open-btn')) return true;

    var btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'bvi-open-btn bvi-open';
    btn.setAttribute('aria-label', 'Версия для слабовидящих');
    btn.setAttribute('title', 'Версия для слабовидящих');
    btn.innerHTML = '<span aria-hidden="true">👁</span>';

    // Вставляем перед тумблером темы или перед соцссылками
    var appearance = nav.querySelector('.VPNavBarAppearance');
    var social = nav.querySelector('.VPNavBarSocialLinks');
    var anchor = appearance || social;

    if (anchor && anchor.parentNode === nav) {
      nav.insertBefore(btn, anchor);
    } else {
      nav.appendChild(btn);
    }
    return true;
  }

  function initBvi() {
    if (!insertButton()) {
      if (++attempts < MAX_ATTEMPTS) { setTimeout(initBvi, 100); }
      return;
    }
    if (typeof Bvi === 'undefined') {
      if (++attempts < MAX_ATTEMPTS) { setTimeout(initBvi, 100); }
      else console.warn('[YL BVI] Bvi constructor not found');
      return;
    }
    try {
      // BVI автоматически цепляется к элементам .bvi-open
      new Bvi({
        // Настройки — можно посмотреть в исходниках node_modules/bvi
        // bviPanelTop: 50,
        // bviPanelLeft: 50,
        // bviPanelWidth: 300,
      });
      console.info('[YL BVI] ready');
    } catch (e) {
      console.error('[YL BVI] init failed:', e);
    }
  }

  // Запускаем после DOMContentLoaded и после маунта навбара VitePress
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initBvi);
  } else {
    initBvi();
  }

  // Если VitePress пересоздаёт navbar при SPA-переходах — реинициализируем
  window.addEventListener('vitepress:routeChanged', function () {
    attempts = 0;
    initBvi();
  });
})();