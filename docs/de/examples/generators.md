# Generatoren

Generatoren nutzen echte **PHP Fibers** — leichtgewichtige Threads.

```yl
§ geraden(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = geraden(10) ⟦
    » "gerade:", x
⟧
```

Ausgabe:

```
gerade: 0
gerade: 2
gerade: 4
gerade: 6
gerade: 8
```

## Endloser Generator

```yl
§ zähler() ⟦
    ¤ i = 0
    @ ☑ ⟦
        ↤ i
        i = i + 1
    ⟧
⟧
```
