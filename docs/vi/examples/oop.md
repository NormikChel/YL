# OOP

Lớp, kế thừa, `this`, ghi đè phương thức.

```yl
‡ Điểm ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ độdài() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Điểm(3, 4)
» "Độ dài:", p.độdài()   ~ 5
```

## Kế thừa

```yl
‡ ĐộngVật ⟦
    ⋔ init(tên :str) ⟦ this.tên = tên ⟧
    ⋔ kêu() ⟦ ^ "..." ⟧
⟧

‡ Chó † ĐộngVật ⟦
    ⋔ kêu() ⟦ ^ "Gâu gâu!" ⟧
⟧

¤ milu = ⇢ Chó("Milu")
» milu.tên + " nói: " + milu.kêu()
```

Kết quả: `Milu nói: Gâu gâu!`
