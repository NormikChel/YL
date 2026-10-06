# Async

`⚡ §` marks an async function. `⏸` awaits its result.

```yl
⚡ § slow(x) ⟦
    ^ x * 2
⟧

¤ t = slow(21)
» "Result:", ⏸ t   ~ 42
```

## Multiple tasks

```yl
⚡ § compute(n) ⟦
    ^ n * n
⟧

¤ a = compute(5)
¤ b = compute(10)
» ⏸ a + ⏸ b   ~ 125
```
