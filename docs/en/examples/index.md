# Examples

A collection of YL examples from simple to advanced.

## Hello world

```yl
» "Hello, world!"
```

## Classes and inheritance

```yl
‡ Animal ⟦
    ⋔ init(name) ⟦ this.name = name ⟧
    ⋔ sound() ⟦ ^ "..." ⟧
⟧

‡ Dog † Animal ⟦
    ⋔ sound() ⟦ ^ "Woof!" ⟧
⟧

¤ rex = ⇢ Dog("Rex")
» rex.name + " says: " + rex.sound()
```

## Closures and map

```yl
¤ squares = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» squares
```

## Generators

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

## Async

```yl
⚡ § slow(x) ⟦ ^ x * 2 ⟧
¤ t = slow(21)
» ⏸ t
```

Full examples in the [GitHub repository](https://github.com/NormikChel/YL/tree/main/examples).
