---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: لغة برمجة غريبة مبنية على PHP بتركيب يونيكود فريد. لا تشبه أي شيء آخر.
  actions:
    - theme: brand
      text: البدء السريع
      link: /ar/guide/getting-started
    - theme: alt
      text: الصياغة
      link: /ar/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: رموز يونيكود فريدة بدلاً من الكلمات المفتاحية.
  - title: برمجة كائنية مع وراثة †
    details: ‡ فئة † الأب، ⋔ دالة، ⇢ new.
  - title: إغلاقات مع map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: مولدات على Fiber
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: غير متزامن ⚡ ⏸
    details: async fn و await مدمجان في اللغة.
  - title: مكتبة + JSON + HTTP
    details: prelude، math، list، string، json، datetime، http.
---

## مثال

```yl
‡ حيوان ⟦
    ⋔ init(اسم :str) ⟦ this.اسم = اسم ⟧
    ⋔ صوت() ⟦ ^ "..." ⟧
⟧

‡ كلب † حيوان ⟦
    ⋔ صوت() ⟦ ^ "هوهو!" ⟧
⟧

¤ ريكس = ⇢ كلب("ريكس")
» ريكس.اسم + " يقول: " + ريكس.صوت()
```

الناتج: `ريكس يقول: هوهو!`
