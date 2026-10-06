---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: Langage de programmation ésotérique en PHP avec une syntaxe Unicode. Rien de comparable.
  actions:
    - theme: brand
      text: Démarrage
      link: /fr/guide/getting-started
    - theme: alt
      text: Syntaxe
      link: /fr/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: Symboles uniques au lieu de mots-clés.
  - title: POO avec héritage †
    details: ‡ Classe † Parent, ⋔ méthode, ⇢ new.
  - title: Fermetures et map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Générateurs sur Fibers
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: Async ⚡ ⏸
    details: async fn et await intégrés au langage.
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http.
---

## Exemple

```yl
‡ Animal ⟦
    ⋔ init(nom :str) ⟦ this.nom = nom ⟧
    ⋔ cri() ⟦ ^ "..." ⟧
⟧

‡ Chien † Animal ⟦
    ⋔ cri() ⟦ ^ "Ouaf !" ⟧
⟧

¤ rex = ⇢ Chien("Rex")
» rex.nom + " dit : " + rex.cri()
```

Sortie : `Rex dit : Ouaf !`
