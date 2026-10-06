# Async

`⚡ §` asenkron işlevi işaretler. `⏸` sonucu bekler.

```yl
⚡ § yavaş(x) ⟦
    ^ x * 2
⟧

¤ t = yavaş(21)
» "Sonuç:", ⏸ t   ~ 42
```

## Birden fazla görev

```yl
⚡ § hesapla(n) ⟦
    ^ n * n
⟧

¤ a = hesapla(5)
¤ b = hesapla(10)
» ⏸ a + ⏸ b   ~ 125
```
