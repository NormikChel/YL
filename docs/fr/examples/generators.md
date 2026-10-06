# Générateurs

Les générateurs utilisent de vrais **PHP Fibers** — threads légers.

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

Sortie :

```
pair : 0
pair : 2
pair : 4
pair : 6
pair : 8
```

## Générateur infini

```yl
§ compteur() ⟦
    ¤ i = 0
    @ ☑ ⟦
        ↤ i
        i = i + 1
    ⟧
⟧
```
