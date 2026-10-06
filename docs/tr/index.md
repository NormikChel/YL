---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: PHP üzerinde çalışan, Unicode sözdizimli egzotik bir programlama dili. Hiçbir şeye benzemiyor.
  actions:
    - theme: brand
      text: Hızlı başlangıç
      link: /tr/guide/getting-started
    - theme: alt
      text: Sözdizimi
      link: /tr/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: Anahtar kelime yerine özgün Unicode semboller.
  - title: † kalıtımlı OOP
    details: ‡ Sınıf † ÜstSınıf, ⋔ metot, ⇢ new.
  - title: Closure ve map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Fiber tabanlı jeneratörler
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: Async ⚡ ⏸
    details: async fn ve await dilin içinde.
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http.
---

## Örnek

```yl
‡ Hayvan ⟦
    ⋔ init(isim :str) ⟦ this.isim = isim ⟧
    ⋔ ses() ⟦ ^ "..." ⟧
⟧

‡ Köpek † Hayvan ⟦
    ⋔ ses() ⟦ ^ "Hav!" ⟧
⟧

¤ rex = ⇢ Köpek("Rex")
» rex.isim + " diyor: " + rex.ses()
```

Çıktı: `Rex diyor: Hav!`
