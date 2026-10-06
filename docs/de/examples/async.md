# Async

`⚡ §` markiert eine asynchrone Funktion. `⏸` wartet auf das Ergebnis.

```yl
⚡ § langsam(x) ⟦
    ^ x * 2
⟧

¤ t = langsam(21)
» "Ergebnis:", ⏸ t   ~ 42
```

## Mehrere Aufgaben

```yl
⚡ § berechne(n) ⟦
    ^ n * n
⟧

¤ a = berechne(5)
¤ b = berechne(10)
» ⏸ a + ⏸ b   ~ 125
```
