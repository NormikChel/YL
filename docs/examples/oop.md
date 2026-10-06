# ООП

```yl
‡ Точка ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ длина() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Точка(3, 4)
» "Длина:", p.длина()   ~ 5
```
