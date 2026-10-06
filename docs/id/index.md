---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: Bahasa pemrograman esoterik di atas PHP dengan sintaks Unicode. Tidak seperti apapun.
  actions:
    - theme: brand
      text: Mulai cepat
      link: /id/guide/getting-started
    - theme: alt
      text: Sintaks
      link: /id/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: Simbol Unicode unik sebagai ganti kata kunci.
  - title: OOP dengan pewarisan †
    details: ‡ Kelas † Induk, ⋔ metode, ⇢ new.
  - title: Closure dan map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Generator di Fiber
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: Async ⚡ ⏸
    details: async fn dan await ada di dalam bahasa.
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http.
---

## Contoh

```yl
‡ Hewan ⟦
    ⋔ init(nama :str) ⟦ this.nama = nama ⟧
    ⋔ suara() ⟦ ^ "..." ⟧
⟧

‡ Anjing † Hewan ⟦
    ⋔ suara() ⟦ ^ "Guk guk!" ⟧
⟧

¤ rex = ⇢ Anjing("Rex")
» rex.nama + " berkata: " + rex.suara()
```

Output: `Rex berkata: Guk guk!`
