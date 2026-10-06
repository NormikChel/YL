# Generators

Generators use real **PHP Fibers** — lightweight threads under the hood.

```yl
§ evens(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = evens(10) ⟦
    » "even:", x
⟧
```

Output:

```
even: 0
even: 2
even: 4
even: 6
even: 8
```

## Infinite generator

```yl
§ counter() ⟦
    ¤ i = 0
    @ ☑ ⟦
        ↤ i
        i = i + 1
    ⟧
⟧
```
