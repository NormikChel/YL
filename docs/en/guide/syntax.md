# Syntax

## Symbols

| Symbol | Meaning |
|---|---|
| `¤` | declare |
| `§` | function |
| `λ` | lambda |
| `»` | print |
| `⟦ ⟧` | block |
| `?` / `¿` | if / else |
| `@` | while |
| `#` | for |
| `⇶` | foreach |
| `^` | return |
| `↤` | yield |
| `‼ ⁇ ⌦` | try/catch/finally |
| `⊕` | import |
| `⊘ ↻` | break/continue |
| `☑ ☐ ∅` | true/false/null |
| `‡ ⋔ ⇢ †` | class machinery |
| `⚡ ⏸` | async/await |

## Variables

```yl
¤ x = 5
¤ name = "Alice"
¤ nums = [1, 2, 3]
¤ person = ⟪"name": "Alice"⟫
```

With types: `¤ x :int = 5`.

## Conditionals

```yl
? x > 5 ⟦
    » "big"
⟧ ¿ ⟦
    » "small"
⟧
```

## Loops

```yl
@ i < 10 ⟦ i = i + 1 ⟧
# i = 0 .. 10 ⟦ » i ⟧
⇶ x = [1, 2, 3] ⟦ » x ⟧
```

## Functions and closures

```yl
§ add(a, b) ⟦ ^ a + b ⟧
¤ double = λ (x) ⟦ ^ x * 2 ⟧
```

## Classes

```yl
‡ Dog ⟦
    ⋔ init(name) ⟦ this.name = name ⟧
    ⋔ sound() ⟦ ^ "Woof!" ⟧
⟧

¤ rex = ⇢ Dog("Rex")
```

## Generators / Async

```yl
§ evens(n) ⟦ # i = 0 .. n ⟦ ? even(i) ⟦ ↤ i ⟧ ⟧ ⟧

⚡ § slow(x) ⟦ ^ x * 2 ⟧
¤ t = slow(21)
» ⏸ t
```

## Error handling

```yl
‼ ⟦ ¤ r = 10 / 0 ⟧ ⁇ e ⟦ » e ⟧ ⌦ ⟦ » "done" ⟧
```
