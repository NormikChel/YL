// YL BVI i18n v2 — перевод панели + правильные голоса для каждой локали
(function () {
  'use strict';

  /* ============ 1. Язык страницы ============ */
  function currentLang() {
    return (document.documentElement.getAttribute('lang') || 'ru').toLowerCase();
  }
  function speechLang() {
    var l = currentLang();
    if (l === 'zh-hans') return 'zh-CN';
    if (l === 'zh-hant') return 'zh-TW';
    return l;
  }
  function speechPrefix() {
    // "en-US" → "en", "zh-CN" → "zh"
    return speechLang().toLowerCase().split('-')[0];
  }

  /* ============ 2. Переводы панели ============ */
  var DICT = {
    'ru': { 'Размер шрифта':'Размер шрифта','Цвета сайта':'Цвета сайта','Изображения':'Изображения',
            'Синтез речи':'Синтез речи','Настройки':'Настройки','Обычная версия сайта':'Обычная версия сайта',
            'Версия для слабовидящих':'Версия для слабовидящих','Чёрно-белая':'Чёрно-белая',
            'Чёрно-жёлтая':'Чёрно-жёлтая','Бежевая':'Бежевая','Синяя':'Синяя','Серая':'Серая',
            'Автоматически':'Автоматически','Голос':'Голос','Встроенные элементы (Видео, карты и т.д.)':'Встроенные элементы (Видео, карты и т.д.)',
            'Межбуквенный интервал':'Межбуквенный интервал','Межстрочный интервал':'Межстрочный интервал','Шрифт':'Шрифт' },
    'en': { 'Размер шрифта':'Font size','Цвета сайта':'Site colors','Изображения':'Images',
            'Синтез речи':'Speech synthesis','Настройки':'Settings','Обычная версия сайта':'Normal version',
            'Версия для слабовидящих':'Visually impaired version','Чёрно-белая':'Black and white',
            'Чёрно-жёлтая':'Black and yellow','Бежевая':'Beige','Синяя':'Blue','Серая':'Gray',
            'Автоматически':'Automatic','Голос':'Voice','Встроенные элементы (Видео, карты и т.д.)':'Embedded elements (Video, maps, etc.)',
            'Межбуквенный интервал':'Letter spacing','Межстрочный интервал':'Line height','Шрифт':'Font' },
    'de': { 'Размер шрифта':'Schriftgröße','Цвета сайта':'Webfarben','Изображения':'Bilder',
            'Синтез речи':'Sprachsynthese','Настройки':'Einstellungen','Обычная версия сайта':'Normale Version',
            'Версия для слабовидящих':'Version für Sehbehinderte','Чёрно-белая':'Schwarz-weiß',
            'Чёрно-жёлтая':'Schwarz-gelb','Бежевая':'Beige','Синяя':'Blau','Серая':'Grau',
            'Автоматически':'Automatisch','Голос':'Stimme','Встроенные элементы (Видео, карты и т.д.)':'Eingebettete Elemente',
            'Межбуквенный интервал':'Zeichenabstand','Межстрочный интервал':'Zeilenabstand','Шрифт':'Schrift' },
    'fr': { 'Размер шрифта':'Taille du texte','Цвета сайта':'Couleurs du site','Изображения':'Images',
            'Синтез речи':'Synthèse vocale','Настройки':'Paramètres','Обычная версия сайта':'Version normale',
            'Версия для слабовидящих':'Version malvoyante','Чёрно-белая':'Noir et blanc',
            'Чёрно-жёлтая':'Noir et jaune','Бежевая':'Beige','Синяя':'Bleu','Серая':'Gris',
            'Автоматически':'Automatique','Голос':'Voix','Встроенные элементы (Видео, карты и т.д.)':'Éléments intégrés',
            'Межбуквенный интервал':'Interlettrage','Межстрочный интервал':'Interligne','Шрифт':'Police' },
    'hi': { 'Размер шрифта':'फ़ॉन्ट आकार','Цвета сайта':'साइट रंग','Изображения':'छवियाँ',
            'Синтез речи':'वाक् संश्लेषण','Настройки':'सेटिंग्स','Обычная версия сайта':'सामान्य संस्करण',
            'Версия для слабовидящих':'दृष्टिबाधित संस्करण','Автоматически':'स्वतः','Голос':'आवाज़',
            'Встроенные элементы (Видео, карты и т.д.)':'अंतर्निहित तत्व',
            'Межбуквенный интервал':'अक्षर अंतराल','Межстрочный интервал':'पंक्ति ऊँचाई','Шрифт':'फ़ॉन्ट' },
    'id': { 'Размер шрифта':'Ukuran font','Цвета сайта':'Warna situs','Изображения':'Gambar',
            'Синтез речи':'Sintesis suara','Настройки':'Pengaturan','Обычная версия сайта':'Versi normal',
            'Версия для слабовидящих':'Versi tunanetra','Автоматически':'Otomatis','Голос':'Suara',
            'Встроенные элементы (Видео, карты и т.д.)':'Elemen tertanam',
            'Межбуквенный интервал':'Spasi huruf','Межстрочный интервал':'Tinggi baris','Шрифт':'Font' },
    'ja': { 'Размер шрифта':'文字サイズ','Цвета сайта':'配色','Изображения':'画像',
            'Синтез речи':'音声合成','Настройки':'設定','Обычная версия сайта':'通常版',
            'Версия для слабовидящих':'視覚障害者向け','Чёрно-белая':'白黒','Чёрно-жёлтая':'黒と黄色',
            'Бежевая':'ベージュ','Синяя':'青','Серая':'グレー','Автоматически':'自動','Голос':'音声',
            'Встроенные элементы (Видео, карты и т.д.)':'埋め込み要素',
            'Межбуквенный интервал':'文字間隔','Межстрочный интервал':'行間','Шрифт':'フォント' },
    'ko': { 'Размер шрифта':'글꼴 크기','Цвета сайта':'사이트 색상','Изображения':'이미지',
            'Синтез речи':'음성 합성','Настройки':'설정','Обычная версия сайта':'일반 버전',
            'Версия для слабовидящих':'시각 장애인용','Автоматически':'자동','Голос':'음성',
            'Встроенные элементы (Видео, карты и т.д.)':'내장 요소',
            'Межбуквенный интервал':'자간','Межстрочный интервал':'줄 높이','Шрифт':'글꼴' },
    'tr': { 'Размер шрифта':'Yazı boyutu','Цвета сайта':'Site renkleri','Изображения':'Resimler',
            'Синтез речи':'Konuşma sentezi','Настройки':'Ayarlar','Обычная версия сайта':'Normal sürüm',
            'Версия для слабовидящих':'Görme engelliler için','Автоматически':'Otomatik','Голос':'Ses',
            'Встроенные элементы (Видео, карты и т.д.)':'Gömülü öğeler',
            'Межбуквенный интервал':'Harf aralığı','Межстрочный интервал':'Satır yüksekliği','Шрифт':'Yazı tipi' },
    'vi': { 'Размер шрифта':'Cỡ chữ','Цвета сайта':'Màu trang','Изображения':'Hình ảnh',
            'Синтез речи':'Tổng hợp giọng nói','Настройки':'Cài đặt','Обычная версия сайта':'Phiên bản thường',
            'Версия для слабовидящих':'Phiên bản khiếm thị','Автоматически':'Tự động','Голос':'Giọng',
            'Встроенные элементы (Видео, карты и т.д.)':'Phần tử nhúng',
            'Межбуквенный интервал':'Khoảng chữ','Межстрочный интервал':'Chiều cao dòng','Шрифт':'Phông chữ' },
    'ar': { 'Размер шрифта':'حجم الخط','Цвета сайта':'ألوان الموقع','Изображения':'الصور',
            'Синтез речи':'تركيب الكلام','Настройки':'الإعدادات','Обычная версия сайта':'النسخة العادية',
            'Версия для слабовидящих':'نسخة ضعاف البصر','Автоматически':'تلقائي','Голос':'صوت',
            'Встроенные элементы (Видео, карты и т.д.)':'عناصر مضمنة',
            'Межбуквенный интервал':'تباعد الأحرف','Межстрочный интервал':'ارتفاع السطر','Шрифт':'الخط' },
    'zh-hans': { 'Размер шрифта':'字号','Цвета сайта':'配色','Изображения':'图片',
                 'Синтез речи':'语音合成','Настройки':'设置','Обычная версия сайта':'普通版本',
                 'Версия для слабовидящих':'无障碍版本','Чёрно-белая':'黑白','Чёрно-жёлтая':'黑黄',
                 'Бежевая':'米色','Синяя':'蓝色','Серая':'灰色','Автоматически':'自动','Голос':'语音',
                 'Встроенные элементы (Видео, карты и т.д.)':'嵌入元素',
                 'Межбуквенный интервал':'字距','Межстрочный интервал':'行距','Шрифт':'字体' },
    'zh-hant': { 'Размер шрифта':'字級','Цвета сайта':'配色','Изображения':'圖片',
                 'Синтез речи':'語音合成','Настройки':'設定','Обычная версия сайта':'一般版本',
                 'Версия для слабовидящих':'無障礙版本','Чёрно-белая':'黑白','Чёрно-жёлтая':'黑黃',
                 'Бежевая':'米色','Синяя':'藍色','Серая':'灰色','Автоматически':'自動','Голос':'語音',
                 'Встроенные элементы (Видео, карты и т.д.)':'嵌入元素',
                 'Межбуквенный интервал':'字距','Межстрочный интервал':'行距','Шрифт':'字體' },
  };

  function getDict() {
    var lang = currentLang();
    if (DICT[lang]) return DICT[lang];
    for (var k in DICT) if (k.toLowerCase() === lang) return DICT[k];
    return DICT['en'];
  }

  /* ============ 3. Перевод текстовых узлов ============ */
  var translated = new WeakSet();

  function translateNode(root) {
    if (!root || root.nodeType !== 1) return;
    var dict = getDict();
    var w = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
    var n;
    while ((n = w.nextNode())) {
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
    var els = root.querySelectorAll('[title],[aria-label],[placeholder]');
    for (var i = 0; i < els.length; i++) {
      ['title','aria-label','placeholder'].forEach(function (attr) {
        var v = els[i].getAttribute(attr);
        if (v && dict[v.trim()] !== undefined) els[i].setAttribute(attr, dict[v.trim()]);
      });
    }
  }

  /* ============ 4. Перестройка списка голосов ============ */
  function collectVoices() {
    if (typeof window.speechSynthesis === 'undefined') return [];
    try { return window.speechSynthesis.getVoices() || []; }
    catch (e) { return []; }
  }

  function voicesForCurrentLang() {
    var all = collectVoices();
    var full = speechLang().toLowerCase();          // "en", "zh-cn"
    var prefix = speechPrefix();                    // "en", "zh"

    // Точное совпадение
    var exact = all.filter(function (v) {
      return v.lang.replace('_','-').toLowerCase() === full;
    });
    if (exact.length) return exact;

    // Совпадение по языку (en-US, en-GB)
    var byLang = all.filter(function (v) {
      return v.lang.replace('_','-').toLowerCase().indexOf(prefix) === 0;
    });
    if (byLang.length) return byLang;

    // Ничего — все голоса
    return all;
  }

  function looksLikeVoiceSelect(sel) {
    if (!sel || sel.tagName !== 'SELECT') return false;
    // Пустой select или содержит опции вида "Name (xx-XX)"
    if (sel.options.length === 0) return true;
    var matches = 0;
    for (var i = 0; i < Math.min(5, sel.options.length); i++) {
      var t = sel.options[i].textContent;
      if (/\([a-z]{2}(-[A-Z]{2})?\)/.test(t)) matches++;
    }
    return matches >= 1;
  }

  function rebuildVoiceSelect(sel) {
    var dict = getDict();
    var voices = voicesForCurrentLang();

    // Сохраняем текущее значение
    var currentValue = sel.value;

    // Строим с нуля
    while (sel.options.length) sel.remove(0);

    // "Автоматически" первой опцией
    var autoOpt = document.createElement('option');
    autoOpt.value = 'auto';
    autoOpt.textContent = dict['Автоматически'] || 'Auto';
    sel.appendChild(autoOpt);

    voices.forEach(function (v) {
      var o = document.createElement('option');
      o.value = v.name;
      o.textContent = v.name + ' (' + v.lang + ')';
      sel.appendChild(o);
    });

    // Восстанавливаем значение, если голос есть в новом списке
    if (currentValue && currentValue !== 'auto') {
      var found = false;
      for (var i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value === currentValue) { found = true; break; }
      }
      sel.value = found ? currentValue : 'auto';
    } else {
      sel.value = 'auto';
    }

    console.info('[YL BVI i18n] voice list rebuilt for', speechLang(), '→', voices.length, 'voices');
  }

  /* ============ 5. Обход панели и патч всего что нужно ============ */
  function handlePanel(root) {
    if (!root) return;
    translateNode(root);
    var selects = root.querySelectorAll('select');
    for (var i = 0; i < selects.length; i++) {
      if (looksLikeVoiceSelect(selects[i])) rebuildVoiceSelect(selects[i]);
    }
  }

  function isBviNode(node) {
    if (!node || node.nodeType !== 1) return false;
    var id = (node.id || '').toLowerCase();
    var cls = (node.className || '').toString().toLowerCase();
    return id.indexOf('bvi') !== -1 || cls.indexOf('bvi') !== -1
        || id.indexOf('isvek') !== -1 || cls.indexOf('isvek') !== -1;
  }

  function scanAll() {
    var panels = document.querySelectorAll(
      '[class*="bvi"],[id*="bvi"],[class*="isvek"],[id*="isvek"]'
    );
    for (var i = 0; i < panels.length; i++) handlePanel(panels[i]);
  }

  /* ============ 6. Override SpeechSynthesisUtterance.lang ============ */
  function patchSpeech() {
    if (typeof window.SpeechSynthesisUtterance !== 'function') return;
    var Proto = window.SpeechSynthesisUtterance.prototype;
    var desc = Object.getOwnPropertyDescriptor(Proto, 'lang');
    if (desc && desc.set && desc.get) {
      Object.defineProperty(Proto, 'lang', {
        configurable: true,
        enumerable: desc.enumerable,
        get: function () { return desc.get.call(this); },
        set: function (_) { desc.set.call(this, speechLang()); },
      });
      console.info('[YL BVI i18n] speech.lang forced to', speechLang());
    }
    if (window.speechSynthesis && typeof window.speechSynthesis.speak === 'function') {
      var orig = window.speechSynthesis.speak.bind(window.speechSynthesis);
      window.speechSynthesis.speak = function (u) {
        try {
          u.lang = speechLang();
          var vs = window.speechSynthesis.getVoices() || [];
          var prefix = speechPrefix();
          for (var i = 0; i < vs.length; i++) {
            var vl = vs[i].lang.replace('_','-').toLowerCase();
            if (vl.indexOf(prefix) === 0) { u.voice = vs[i]; break; }
          }
        } catch (e) {}
        return orig(u);
      };
    }
  }

  /* ============ 7. Boot ============ */
  var obs = new MutationObserver(function (muts) {
    for (var i = 0; i < muts.length; i++) {
      var m = muts[i];
      for (var j = 0; j < m.addedNodes.length; j++) {
        var n = m.addedNodes[j];
        if (n.nodeType === 1 && isBviNode(n)) {
          setTimeout(function () { handlePanel(n); }, 0);
        }
      }
    }
  });

  function boot() {
    patchSpeech();

    // Chrome отдаёт getVoices() пустым до события voiceschanged
    if (window.speechSynthesis) {
      window.speechSynthesis.addEventListener('voiceschanged', function () {
        scanAll();
      });
    }

    // Первое сканирование
    scanAll();
    obs.observe(document.body, { childList: true, subtree: true });

    // SPA-переход на другую локаль
    window.addEventListener('vitepress:routeChanged', function () {
      translated = new WeakSet();
      setTimeout(scanAll, 100);
    });

    console.info('[YL BVI i18n] ready, lang =', currentLang(), '→ speech:', speechLang());
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();