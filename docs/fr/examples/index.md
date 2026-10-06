# Exemples

Collection d'exemples YL, du plus simple au plus avancé.

## Hello world

```yl
» "Bonjour, monde !"
```

## Classes et héritage

```yl
‡ Animal ⟦
    ⋔ init(nom) ⟦ this.nom = nom ⟧
    ⋔ cri() ⟦ ^ "..." ⟧
⟧

‡ Chien † Animal ⟦
    ⋔ cri() ⟦ ^ "Ouaf !" ⟧
⟧

¤ rex = ⇢ Chien("Rex")
» rex.nom + " dit : " + rex.cri()
```

## Fermetures et map

```yl
¤ carrés = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» carrés
```

## Générateurs

```yl
§ pairs(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = pairs(10) ⟦
    » "pair :", x
⟧
```

## Async

```yl
⚡ § lent(x) ⟦ ^ x * 2 ⟧
¤ t = lent(21)
» ⏸ t
```

Exemples complets dans le [dépôt GitHub](https://github.com/NormikChel/YL/tree/main/examples).
