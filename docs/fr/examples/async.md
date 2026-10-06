# Async

`⚡ §` marque une fonction asynchrone. `⏸` attend le résultat.

```yl
⚡ § lent(x) ⟦
    ^ x * 2
⟧

¤ t = lent(21)
» "Résultat :", ⏸ t   ~ 42
```

## Plusieurs tâches

```yl
⚡ § calcule(n) ⟦
    ^ n * n
⟧

¤ a = calcule(5)
¤ b = calcule(10)
» ⏸ a + ⏸ b   ~ 125
```
