# Beispiele

Sammlung von YL-Beispielen von einfach bis fortgeschritten.

## Hello world

```yl
» "Hallo, Welt!"
```

## Klassen und Vererbung

```yl
‡ Tier ⟦
    ⋔ init(name) ⟦ this.name = name ⟧
    ⋔ laut() ⟦ ^ "..." ⟧
⟧

‡ Hund † Tier ⟦
    ⋔ laut() ⟦ ^ "Wuff!" ⟧
⟧

¤ rex = ⇢ Hund("Rex")
» rex.name + " sagt: " + rex.laut()
```

## Closures und map

```yl
¤ quadrate = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» quadrate
```

## Generatoren

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

## Async

```yl
⚡ § langsam(x) ⟦ ^ x * 2 ⟧
¤ t = langsam(21)
» ⏸ t
```

Vollständige Beispiele im [GitHub-Repository](https://github.com/NormikChel/YL/tree/main/examples).
