# Syntax

## Symbole

| Symbol | Bedeutung |
|---|---|
| `~` | Kommentar |
| `¤` | Variable deklarieren |
| `§` | Funktion |
| `λ` | Lambda |
| `»` | Ausgabe |
| `⟦ ⟧` | Block |
| `?` / `¿` | wenn / sonst |
| `@` | while |
| `#` | for |
| `⇶` | foreach |
| `^` | return |
| `↤` | yield |
| `‼ ⁇ ⌦` | try / catch / finally |
| `⊕` | Import |
| `⊘` / `↻` | break / continue |
| `☑` / `☐` / `∅` | true / false / null |
| `‡` | Klasse |
| `⋔` | Methode |
| `⇢` | new |
| `†` | Vererbung |
| `⚡` / `⏸` | async / await |

## Variablen

```yl
¤ x = 5
¤ name = "Anna"
¤ zahlen = [1, 2, 3]
¤ person = ⟪"name": "Anna", "alter": 25⟫
```

Mit Typen: `¤ x :int = 5`

## Bedingungen

```yl
? x > 5 ⟦
    » "größer als 5"
⟧ ¿ ⟦
    » "kleiner oder gleich"
⟧
```

## Schleifen

```yl
@ i < 10 ⟦ i = i + 1 ⟧
# i = 0 .. 10 ⟦ » i ⟧
⇶ x = [1, 2, 3] ⟦ » x ⟧
```

## Funktionen

```yl
§ add(a, b) ⟦ ^ a + b ⟧
§ sqrt_newton(x :float) :float ⟦
    ? x <= 0 ⟦ ^ 0 ⟧
    ¤ g = x / 2
    # i = 0 .. 10 ⟦ g = (g + x / g) / 2 ⟧
    ^ g
⟧
```

## Closures

```yl
¤ verdoppeln = λ (x) ⟦ ^ x * 2 ⟧
```

## Klassen

```yl
‡ Hund ⟦
    ⋔ init(name) ⟦ this.name = name ⟧
    ⋔ laut() ⟦ ^ "Wuff!" ⟧
⟧

¤ rex = ⇢ Hund("Rex")
```

## Generatoren

```yl
§ geraden(n) ⟦
    # i = 0 .. n ⟦ ? even(i) ⟦ ↤ i ⟧ ⟧
⟧

⇶ x = geraden(10) ⟦ » x ⟧
```

## Async

```yl
⚡ § langsam(x) ⟦ ^ x * 2 ⟧
¤ t = langsam(21)
» ⏸ t
```

## Fehlerbehandlung

```yl
‼ ⟦ ¤ r = 10 / 0 ⟧ ⁇ e ⟦ » "Gefangen:", e ⟧ ⌦ ⟦ » "finally" ⟧
```
