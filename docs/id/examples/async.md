# Async

`⚡ §` menandai fungsi async. `⏸` menunggu hasilnya.

```yl
⚡ § lambat(x) ⟦
    ^ x * 2
⟧

¤ t = lambat(21)
» "Hasil:", ⏸ t   ~ 42
```

## Beberapa tugas

```yl
⚡ § hitung(n) ⟦
    ^ n * n
⟧

¤ a = hitung(5)
¤ b = hitung(10)
» ⏸ a + ⏸ b   ~ 125
```
