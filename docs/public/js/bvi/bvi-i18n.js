// YL BVI i18n — перевод панели + фикс языка синтеза речи
(function () {
  'use strict';

  /* ---------- 1. Определяем текущий язык страницы ---------- */
  function currentLang() {
    var l = (document.documentElement.getAttribute('lang') || 'ru').toLowerCase();
    // VitePress локали: zh-Hans / zh-Hant / be-latn / en / ru / ...
    return l;
  }

  // Для речевого API нужен BCP-47 в стиле zh-CN / zh-TW
  function speechLang() {
    var l = currentLang();
    if (l === 'zh-hans') return 'zh-CN';
    if (l === 'zh-hant') return 'zh-TW';
    return l;
  }

  /* ---------- 2. Словари переводов панели ---------- */
  // Ключи — оригинальные русские тексты BVI.
  // Значения — перевод на язык страницы.
  var DICT = {
    'ru': {
      'Размер шрифта': 'Размер шрифта',
      'Цвета сайта': 'Цвета сайта',
      'Изображения': 'Изображения',
      'Синтез речи': 'Синтез речи',
      'Настройки': 'Настройки',
      'Обычная версия сайта': 'Обычная версия сайта',
      'Версия для слабовидящих': 'Версия для слабовидящих',
      'Чёрно-белая': 'Чёрно-белая',
      'Чёрно-жёлтая': 'Чёрно-жёлтая',
      'Бежевая': 'Бежевая',
      'Синяя': 'Синяя',
      'Серая': 'Серая',
      'Включить/выключить': 'Включить/выключить',
      'Озвучить': 'Озвучить',
      'Остановить': 'Остановить',
    },
    'en': {
      'Размер шрифта': 'Font size',
      'Цвета сайта': 'Site colors',
      'Изображения': 'Images',
      'Синтез речи': 'Speech synthesis',
      'Настройки': 'Settings',
      'Обычная версия сайта': 'Normal site version',
      'Версия для слабовидящих': 'Visually impaired version',
      'Чёрно-белая': 'Black and white',
      'Чёрно-жёлтая': 'Black and yellow',
      'Бежевая': 'Beige',
      'Синяя': 'Blue',
      'Серая': 'Gray',
      'Включить/выключить': 'Toggle',
      'Озвучить': 'Speak',
      'Остановить': 'Stop',
    },
    'de': {
      'Размер шрифта': 'Schriftgröße',
      'Цвета сайта': 'Webfarben',
      'Изображения': 'Bilder',
      'Синтез речи': 'Sprachsynthese',
      'Настройки': 'Einstellungen',
      'Обычная версия сайта': 'Normale Version',
      'Версия для слабовидящих': 'Version für Sehbehinderte',
      'Чёрно-белая': 'Schwarz-weiß',
      'Чёрно-жёлтая': 'Schwarz-gelb',
      'Бежевая': 'Beige',
      'Синяя': 'Blau',
      'Серая': 'Grau',
    },
    'fr': {
      'Размер шрифта': 'Taille du texte',
      'Цвета сайта': 'Couleurs du site',
      'Изображения': 'Images',
      'Синтез речи': 'Synthèse vocale',
      'Настройки': 'Paramètres',
      'Обычная версия сайта': 'Version normale',
      'Версия для слабовидящих': 'Version malvoyante',
      'Чёрно-белая': 'Noir et blanc',
      'Чёрно-жёлтая': 'Noir et jaune',
      'Бежевая': 'Beige',
      'Синяя': 'Bleu',
      'Серая': 'Gris',
    },
    'hi': {
      'Размер шрифта': 'फ़ॉन्ट आकार',
      'Цвета сайта': 'साइट रंग',
      'Изображения': 'छवियाँ',
      'Синтез речи': 'वाक् संश्लेषण',
      'Настройки': 'सेटिंग्स',
      'Обычная версия сайта': 'सामान्य संस्करण',
      'Версия для слабовидящих': 'दृष्टिबाधित संस्करण',
    },
    'id': {
      'Размер шрифта': 'Ukuran font',
      'Цвета сайта': 'Warna situs',
      'Изображения': 'Gambar',
      'Синтез речи': 'Sintesis suara',
      'Настройки': 'Pengaturan',
      'Обычная версия сайта': 'Versi normal',
      'Версия для слабовидящих': 'Versi tunanetra',
    },
    'ja': {
      'Размер шрифта': '文字サイズ',
      'Цвета сайта': '配色',
      'Изображения': '画像',
      'Синтез речи': '音声合成',
      'Настройки': '設定',
      'Обычная версия сайта': '通常版',
      'Версия для слабовидящих': '視覚障害者向け',
      'Чёрно-белая': '白黒',
      'Чёрно-жёлтая': '黒と黄色',
      'Бежевая': 'ベージュ',
      'Синяя': '青',
      'Серая': 'グレー',
    },
    'ko': {
      'Размер шрифта': '글꼴 크기',
      'Цвета сайта': '사이트 색상',
      'Изображения': '이미지',
      'Синтез речи': '음성 합성',
      'Настройки': '설정',
      'Обычная версия сайта': '일반 버전',
      'Версия для слабовидящих': '시각 장애인용',
    },
    'tr': {
      'Размер шрифта': 'Yazı boyutu',
      'Цвета сайта': 'Site renkleri',
      'Изображения': 'Resimler',
      'Синтез речи': 'Konuşma sentezi',
      'Настройки': 'Ayarlar',
      'Обычная версия сайта': 'Normal sürüm',
      'Версия для слабовидящих': 'Görme engelliler için',
    },
    'vi': {
      'Размер шрифта': 'Cỡ chữ',
      'Цвета сайта': 'Màu trang',
      'Изображения': 'Hình ảnh',
      'Синтез речи': 'Tổng hợp giọng nói',
      'Настройки': 'Cài đặt',
      'Обычная версия сайта': 'Phiên bản thường',
      'Версия для слабовидящих': 'Phiên bản khiếm thị',
    },
    'ar': {
      'Размер шрифта': 'حجم الخط',
      'Цвета сайта': 'ألوان الموقع',
      'Изображения': 'الصور',
      'Синтез речи': 'تركيب الكلام',
      'Настройки': 'الإعدادات',
      'Обычная версия сайта': 'النسخة العادية',
      'Версия для слабовидящих': 'نسخة ضعاف البصر',
    },
    'zh-hans': {
      'Размер шрифта': '字号',
      'Цвета сайта': '配色',
      'Изображения': '图片',
      'Синтез речи': '语音合成',
      'Настройки': '设置',
      'Обычная версия сайта': '普通版本',
      'Версия для слабовидящих': '无障碍版本',
      'Чёрно-белая': '黑白',
      'Чёрно-жёлтая': '黑黄',
      'Бежевая': '米色',
      'Синяя': '蓝色',
      'Серая': '灰色',
    },
    'zh-hant': {
      'Размер шрифта': '字級',
      'Цвета сайта': '配色',
      'Изображения': '圖片',
      'Синтез речи': '語音合成',
      'Настройки': '設定',
      'Обычная версия сайта': '一般版本',
      'Версия для слабовидящих': '無障礙版本',
      'Чёрно-белая': '黑白',
      'Чёрно-жёлтая': '黑黃',
      'Бежевая': '米色',
      'Синяя': '藍色',
      'Серая': '灰色',
    },
  };

  function getDict() {
    var lang = currentLang();
    if (DICT[lang]) return DICT[lang];
    // zh-Hans пишется с большой H, ищем без учёта регистра
    for (var k in DICT) {
      if (k.toLowerCase() === lang) return DICT[k];
    }
    return DICT['en'];
  }

  /* ---------- 3. Перевод текстовых узлов внутри элемента ---------- */
  var translated = new WeakSet();

  function translateNode(root) {
    var dict = getDict();
    var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
    var n;
    while ((n = walker.nextNode())) {
      if (translated.has(n)) continue;
      var txt = n.nodeValue;
      if (!txt) continue;
      var trimmed = txt.trim();
      if (!trimmed) continue;
      if (dict[trimmed] !== undefined) {
        n.nodeValue = txt.replace(trimmed, dict[trimmed]);
        translated.add(n);
      }
    }
    // title и aria-label
    var els = root.querySelectorAll('[title],[aria-label]');
    for (var i = 0; i < els.length; i++) {
      ['title', 'aria-label'].forEach(function (attr) {
        var v = els[i].getAttribute(attr);
        if (v && dict[v.trim()] !== undefined) {
          els[i].setAttribute(attr, dict[v.trim()]);
        }
      });
    }
  }

  /* ---------- 4. MutationObserver: ловим появление панели BVI ---------- */
  function isBviPanel(node) {
    if (!node || node.nodeType !== 1) return false;
    // BVI создаёт элементы с классом/id содержащим 'bvi' или 'isvek'
    var id = (node.id || '').toLowerCase();
    var cls = (node.className || '').toString().toLowerCase();
    return id.indexOf('bvi') !== -1 || cls.indexOf('bvi') !== -1
        || id.indexOf('isvek') !== -1 || cls.indexOf('isvek') !== -1;
  }

  function scanForBvi() {
    // Переводим всё что нашли в body — filter сам отсеет
    var panels = document.querySelectorAll('[class*="bvi"],[id*="bvi"],[class*="isvek"],[id*="isvek"]');
    for (var i = 0; i < panels.length; i++) {
      translateNode(panels[i]);
    }
  }

  var obs = new MutationObserver(function (mutations) {
    for (var i = 0; i < mutations.length; i++) {
      var m = mutations[i];
      for (var j = 0; j < m.addedNodes.length; j++) {
        var n = m.addedNodes[j];
        if (n.nodeType === 1 && isBviPanel(n)) {
          translateNode(n);
          scanForBvi();
        }
      }
    }
  });

  /* ---------- 5. Override lang у SpeechSynthesisUtterance ---------- */
  function patchSpeech() {
    if (typeof window.SpeechSynthesisUtterance !== 'function') return;

    var Proto = window.SpeechSynthesisUtterance.prototype;
    var desc = Object.getOwnPropertyDescriptor(Proto, 'lang');

    if (desc && desc.set && desc.get) {
      Object.defineProperty(Proto, 'lang', {
        configurable: true,
        enumerable: desc.enumerable,
        get: function () { return desc.get.call(this); },
        set: function (_ignored) {
          // Принудительно ставим текущий язык страницы
          desc.set.call(this, speechLang());
        },
      });
      console.info('[YL BVI i18n] speech.lang override →', speechLang());
    }

    // Подстраховка: патчим speak() — если BVI ставит lang после конструирования
    if (window.speechSynthesis && typeof window.speechSynthesis.speak === 'function') {
      var origSpeak = window.speechSynthesis.speak.bind(window.speechSynthesis);
      window.speechSynthesis.speak = function (u) {
        try {
          u.lang = speechLang();
          var voices = window.speechSynthesis.getVoices();
          for (var i = 0; i < voices.length; i++) {
            if (voices[i].lang.replace('_', '-').toLowerCase().indexOf(speechLang().toLowerCase()) === 0) {
              u.voice = voices[i];
              break;
            }
          }
        } catch (e) {}
        return origSpeak(u);
      };
    }
  }

  /* ---------- 6. Boot ---------- */
  function boot() {
    patchSpeech();
    scanForBvi();
    obs.observe(document.body, { childList: true, subtree: true });

    // После смены локали в SPA — сбросить кеш переводов
    window.addEventListener('vitepress:routeChanged', function () {
      translated = new WeakSet();  // это вызывает ошибку — переменная const
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  console.info('[YL BVI i18n] ready, lang =', currentLang());
})();