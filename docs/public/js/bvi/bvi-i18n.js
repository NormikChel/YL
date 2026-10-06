// YL BVI i18n v2 — полный словарь + fix голосов
(function () {
  'use strict';

  function currentLang() {
    var l = (document.documentElement.getAttribute('lang') || 'ru').toLowerCase();
    return l;
  }
  function speechLang() {
    var l = currentLang();
    if (l === 'zh-hans') return 'zh-CN';
    if (l === 'zh-hant') return 'zh-TW';
    if (l === 'be') return 'be-BY';
    return l;
  }

  /* ========== ПОЛНЫЙ СЛОВАРЬ ========== */
  // Все текстовые строки из интерфейса BVI + наших тултипов.
  var DICT = {
    'ru': {}, // русский = исходник, ничего не переводим

    'en': {
      'Размер шрифта': 'Font size',
      'Цвета сайта': 'Site colors',
      'Изображения': 'Images',
      'Синтез речи': 'Speech synthesis',
      'Настройки': 'Settings',
      'Обычная версия сайта': 'Normal version',
      'Версия для слабовидящих': 'Visually impaired version',
      'Межбуквенное расстояние': 'Letter spacing',
      'Стандартный': 'Normal',
      'Средний': 'Medium',
      'Большой': 'Large',
      'Межстрочный интервал': 'Line height',
      'Шрифт': 'Font',
      'Без засечек': 'Sans-serif',
      'С засечками': 'Serif',
      'Встроенные элементы (Видео, карты и т.д.)': 'Embedded elements (video, maps, etc.)',
      'Включить': 'On',
      'Выключить': 'Off',
      'Голос': 'Voice',
      'Сбросить настройки': 'Reset settings',
      'Закрыть': 'Close',
      'Чёрно-белая': 'Black and white',
      'Чёрно-жёлтая': 'Black and yellow',
      'Бежевая': 'Beige',
      'Синяя': 'Blue',
      'Серая': 'Gray',
      'Звук': 'Sound',
      'Включить озвучивание': 'Enable speech',
      'Выключить озвучивание': 'Disable speech',
    },

    'de': {
      'Размер шрифта': 'Schriftgröße',
      'Цвета сайта': 'Webfarben',
      'Изображения': 'Bilder',
      'Синтез речи': 'Sprachsynthese',
      'Настройки': 'Einstellungen',
      'Обычная версия сайта': 'Normale Version',
      'Версия для слабовидящих': 'Version für Sehbehinderte',
      'Межбуквенное расстояние': 'Buchstabenabstand',
      'Стандартный': 'Standard',
      'Средний': 'Mittel',
      'Большой': 'Groß',
      'Межстрочный интервал': 'Zeilenabstand',
      'Шрифт': 'Schriftart',
      'Без засечек': 'Sans-Serif',
      'С засечками': 'Serif',
      'Встроенные элементы (Видео, карты и т.д.)': 'Eingebettete Elemente',
      'Включить': 'Ein',
      'Выключить': 'Aus',
      'Голос': 'Stimme',
      'Сбросить настройки': 'Zurücksetzen',
      'Закрыть': 'Schließen',
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
      'Межбуквенное расстояние': 'Espacement des lettres',
      'Стандартный': 'Normal',
      'Средний': 'Moyen',
      'Большой': 'Grand',
      'Межстрочный интервал': 'Interligne',
      'Шрифт': 'Police',
      'Без засечек': 'Sans-serif',
      'С засечками': 'Serif',
      'Встроенные элементы (Видео, карты и т.д.)': 'Éléments intégrés',
      'Включить': 'Activé',
      'Выключить': 'Désactivé',
      'Голос': 'Voix',
      'Сбросить настройки': 'Réinitialiser',
      'Закрыть': 'Fermer',
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
      'Межбуквенное расстояние': 'अक्षर अंतराल',
      'Стандартный': 'सामान्य',
      'Средний': 'मध्यम',
      'Большой': 'बड़ा',
      'Межстрочный интервал': 'पंक्ति अंतराल',
      'Шрифт': 'फ़ॉन्ट',
      'Без засечек': 'सैन्स-सेरिफ़',
      'С засечками': 'सेरिफ़',
      'Встроенные элементы (Видео, карты и т.д.)': 'एम्बेडेड तत्व',
      'Включить': 'चालू',
      'Выключить': 'बंद',
      'Голос': 'आवाज़',
      'Сбросить настройки': 'रीसेट',
      'Закрыть': 'बंद करें',
    },

    'id': {
      'Размер шрифта': 'Ukuran font',
      'Цвета сайта': 'Warna situs',
      'Изображения': 'Gambar',
      'Синтез речи': 'Sintesis suara',
      'Настройки': 'Pengaturan',
      'Обычная версия сайта': 'Versi normal',
      'Версия для слабовидящих': 'Versi tunanetra',
      'Межбуквенное расстояние': 'Jarak antar huruf',
      'Стандартный': 'Standar',
      'Средний': 'Sedang',
      'Большой': 'Besar',
      'Межстрочный интервал': 'Jarak antar baris',
      'Шрифт': 'Font',
      'Без засечек': 'Sans-serif',
      'С засечками': 'Serif',
      'Встроенные элементы (Видео, карты и т.д.)': 'Elemen tersemat',
      'Включить': 'Nyala',
      'Выключить': 'Mati',
      'Голос': 'Suara',
      'Сбросить настройки': 'Atur ulang',
      'Закрыть': 'Tutup',
    },

    'ja': {
      'Размер шрифта': '文字サイズ',
      'Цвета сайта': '配色',
      'Изображения': '画像',
      'Синтез речи': '音声合成',
      'Настройки': '設定',
      'Обычная версия сайта': '通常版',
      'Версия для слабовидящих': '視覚障害者向け',
      'Межбуквенное расстояние': '文字間隔',
      'Стандартный': '標準',
      'Средний': '中',
      'Большой': '大',
      'Межстрочный интервал': '行間',
      'Шрифт': 'フォント',
      'Без засечек': 'サンセリフ',
      'С засечками': 'セリフ',
      'Встроенные элементы (Видео, карты и т.д.)': '埋め込み要素',
      'Включить': 'オン',
      'Выключить': 'オフ',
      'Голос': '音声',
      'Сбросить настройки': 'リセット',
      'Закрыть': '閉じる',
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
      'Межбуквенное расстояние': '자간',
      'Стандартный': '표준',
      'Средний': '중간',
      'Большой': '크게',
      'Межстрочный интервал': '줄 간격',
      'Шрифт': '글꼴',
      'Без засечек': '산세리프',
      'С засечками': '세리프',
      'Встроенные элементы (Видео, карты и т.д.)': '내장 요소',
      'Включить': '켜기',
      'Выключить': '끄기',
      'Голос': '음성',
      'Сбросить настройки': '초기화',
      'Закрыть': '닫기',
    },

    'tr': {
      'Размер шрифта': 'Yazı boyutu',
      'Цвета сайта': 'Site renkleri',
      'Изображения': 'Resimler',
      'Синтез речи': 'Konuşma sentezi',
      'Настройки': 'Ayarlar',
      'Обычная версия сайта': 'Normal sürüm',
      'Версия для слабовидящих': 'Görme engelliler için',
      'Межбуквенное расстояние': 'Harf aralığı',
      'Стандартный': 'Standart',
      'Средний': 'Orta',
      'Большой': 'Büyük',
      'Межстрочный интервал': 'Satır aralığı',
      'Шрифт': 'Yazı tipi',
      'Без засечек': 'Serifsiz',
      'С засечками': 'Serifli',
      'Встроенные элементы (Видео, карты и т.д.)': 'Gömülü öğeler',
      'Включить': 'Açık',
      'Выключить': 'Kapalı',
      'Голос': 'Ses',
      'Сбросить настройки': 'Sıfırla',
      'Закрыть': 'Kapat',
    },

    'vi': {
      'Размер шрифта': 'Cỡ chữ',
      'Цвета сайта': 'Màu trang',
      'Изображения': 'Hình ảnh',
      'Синтез речи': 'Tổng hợp giọng nói',
      'Настройки': 'Cài đặt',
      'Обычная версия сайта': 'Phiên bản thường',
      'Версия для слабовидящих': 'Phiên bản khiếm thị',
      'Межбуквенное расстояние': 'Khoảng cách chữ',
      'Стандартный': 'Chuẩn',
      'Средний': 'Trung bình',
      'Большой': 'Lớn',
      'Межстрочный интервал': 'Khoảng cách dòng',
      'Шрифт': 'Phông chữ',
      'Без засечек': 'Không chân',
      'С засечками': 'Có chân',
      'Встроенные элементы (Видео, карты и т.д.)': 'Phần tử nhúng',
      'Включить': 'Bật',
      'Выключить': 'Tắt',
      'Голос': 'Giọng nói',
      'Сбросить настройки': 'Đặt lại',
      'Закрыть': 'Đóng',
    },

    'ar': {
      'Размер шрифта': 'حجم الخط',
      'Цвета сайта': 'ألوان الموقع',
      'Изображения': 'الصور',
      'Синтез речи': 'تركيب الكلام',
      'Настройки': 'الإعدادات',
      'Обычная версия сайта': 'النسخة العادية',
      'Версия для слабовидящих': 'نسخة ضعاف البصر',
      'Межбуквенное расстояние': 'تباعد الأحرف',
      'Стандартный': 'قياسي',
      'Средний': 'متوسط',
      'Большой': 'كبير',
      'Межстрочный интервал': 'تباعد الأسطر',
      'Шрифт': 'الخط',
      'Без засечек': 'بدون حواشي',
      'С засечками': 'بحواشي',
      'Встроенные элементы (Видео, карты и т.д.)': 'العناصر المدمجة',
      'Включить': 'تشغيل',
      'Выключить': 'إيقاف',
      'Голос': 'الصوت',
      'Сбросить настройки': 'إعادة تعيين',
      'Закрыть': 'إغلاق',
    },

    'zh-hans': {
      'Размер шрифта': '字号',
      'Цвета сайта': '配色',
      'Изображения': '图片',
      'Синтез речи': '语音合成',
      'Настройки': '设置',
      'Обычная версия сайта': '普通版本',
      'Версия для слабовидящих': '无障碍版本',
      'Межбуквенное расстояние': '字距',
      'Стандартный': '标准',
      'Средний': '中等',
      'Большой': '大',
      'Межстрочный интервал': '行距',
      'Шрифт': '字体',
      'Без засечек': '无衬线',
      'С засечками': '衬线',
      'Встроенные элементы (Видео, карты и т.д.)': '嵌入元素',
      'Включить': '开启',
      'Выключить': '关闭',
      'Голос': '声音',
      'Сбросить настройки': '重置',
      'Закрыть': '关闭',
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
      'Межбуквенное расстояние': '字距',
      'Стандартный': '標準',
      'Средний': '中等',
      'Большой': '大',
      'Межстрочный интервал': '行距',
      'Шрифт': '字型',
      'Без засечек': '無襯線',
      'С засечками': '襯線',
      'Встроенные элементы (Видео, карты и т.д.)': '嵌入元素',
      'Включить': '開啟',
      'Выключить': '關閉',
      'Голос': '聲音',
      'Сбросить настройки': '重置',
      'Закрыть': '關閉',
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
    for (var k in DICT) {
      if (k.toLowerCase() === lang) return DICT[k];
    }
    return DICT['en'];
  }

  /* ========== Переводим DOM-узел целиком ========== */
  var translatedNodes = new WeakSet();

  function translateNode(root) {
    var dict = getDict();
    if (!dict || Object.keys(dict).length === 0) return;

    // 1. Текстовые узлы
    var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
    var n;
    while ((n = walker.nextNode())) {
      if (translatedNodes.has(n)) continue;
      var txt = n.nodeValue;
      if (!txt) continue;
      var trimmed = txt.trim();
      if (!trimmed) continue;
      if (dict[trimmed] !== undefined) {
        n.nodeValue = txt.replace(trimmed, dict[trimmed]);
        translatedNodes.add(n);
      }
    }

    // 2. title / aria-label
    var els = root.querySelectorAll ? root.querySelectorAll('[title],[aria-label]') : [];
    for (var i = 0; i < els.length; i++) {
      ['title', 'aria-label'].forEach(function (attr) {
        var v = els[i].getAttribute(attr);
        if (v && dict[v.trim()] !== undefined) els[i].setAttribute(attr, dict[v.trim()]);
      });
    }
  }

  /* ========== Патч SpeechSynthesisUtterance ========== */
  function patchSpeech() {
    if (typeof window.SpeechSynthesisUtterance !== 'function') return;
    if (window.__yl_speech_patched) return;
    window.__yl_speech_patched = true;

    var Orig = window.SpeechSynthesisUtterance;
    var forced = null; // язык, который BVI пытался поставить

    function Patched(text) {
      var u = new Orig(text);
      // принудительно наш язык
      try {
        Orig.prototype.lang && Object.getOwnPropertyDescriptor(Orig.prototype, 'lang');
      } catch (e) {}
      Object.defineProperty(u, 'lang', {
        configurable: true,
        get: function () { return speechLang(); },
        set: function (_) { /* игнорируем */ },
      });
      return u;
    }
    Patched.prototype = Orig.prototype;
    window.SpeechSynthesisUtterance = Patched;

    // Дополнительный override speak — гарантия
    if (window.speechSynthesis) {
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
    console.info('[YL BVI i18n] speech.lang →', speechLang());
  }

  /* ========== Скан и MutationObserver ========== */
  function scanAll() {
    // Ищем контейнеры BVI по классам/id
    var selectors = [
      '[class*="bvi"]', '[id*="bvi"]',
      '[class*="isvek"]', '[id*="isvek"]',
      '.bvi-panel', '.bvi-block',
    ];
    var seen = new Set();
    for (var i = 0; i < selectors.length; i++) {
      var list = document.querySelectorAll(selectors[i]);
      for (var j = 0; j < list.length; j++) {
        if (seen.has(list[j])) continue;
        seen.add(list[j]);
        translateNode(list[j]);
      }
    }
  }

  function boot() {
    patchSpeech();
    scanAll();

    // MutationObserver: ловим добавление/изменение панели
    var mo = new MutationObserver(function (muts) {
      var shouldScan = false;
      for (var i = 0; i < muts.length; i++) {
        var m = muts[i];
        for (var j = 0; j < m.addedNodes.length; j++) {
          var nn = m.addedNodes[j];
          if (nn.nodeType === 1) {
            var cls = (nn.className || '').toString().toLowerCase();
            var id = (nn.id || '').toLowerCase();
            if (cls.indexOf('bvi') !== -1 || id.indexOf('bvi') !== -1
             || cls.indexOf('isvek') !== -1 || id.indexOf('isvek') !== -1) {
              shouldScan = true;
              break;
            }
          }
        }
        if (shouldScan) break;
      }
      if (shouldScan) {
        // даём BVI дорисовать панель
        setTimeout(scanAll, 30);
        setTimeout(scanAll, 120);
        setTimeout(scanAll, 400);
      }
    });
    mo.observe(document.body, { childList: true, subtree: true });

    // Fallback: повторяем периодически первые 5 секунд
    var n = 0;
    var iv = setInterval(function () {
      scanAll();
      if (++n >= 20) clearInterval(iv);
    }, 250);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  console.info('[YL BVI i18n v2] ready, lang =', currentLang());
})();