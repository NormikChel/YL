---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: Esoterische Programmiersprache auf PHP mit Unicode-Syntax. Anders als alles andere.
  actions:
    - theme: brand
      text: Erste Schritte
      link: /de/guide/getting-started
    - theme: alt
      text: Syntax
      link: /de/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: Einzigartige Symbole statt Schlüsselwörter.
  - title: OOP mit †-Vererbung
    details: ‡ Klasse † Elternklasse, ⋔ Methode, ⇢ Instanz.
  - title: Closures und map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Generatoren auf Fibers
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: Async ⚡ ⏸
    details: async fn und await direkt in der Sprache.
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http.
---

## Beispiel

```yl
‡ Tier ⟦
    ⋔ init(name :str) ⟦ this.name = name ⟧
    ⋔ laut() ⟦ ^ "..." ⟧
⟧

‡ Hund † Tier ⟦
    ⋔ laut() ⟦ ^ "Wuff!" ⟧
⟧

¤ rex = ⇢ Hund("Rex")
» rex.name + " sagt: " + rex.laut()
```

Ausgabe: `Rex sagt: Wuff!`
