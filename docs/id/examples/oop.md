# OOP

Kelas, pewarisan, `this`, override metode.

```yl
‡ Titik ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ panjang() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Titik(3, 4)
» "Panjang:", p.panjang()   ~ 5
```

## Pewarisan

```yl
‡ Hewan ⟦
    ⋔ init(nama :str) ⟦ this.nama = nama ⟧
    ⋔ suara() ⟦ ^ "..." ⟧
⟧

‡ Anjing † Hewan ⟦
    ⋔ suara() ⟦ ^ "Guk guk!" ⟧
⟧

¤ rex = ⇢ Anjing("Rex")
» rex.nama + " berkata: " + rex.suara()
```

Output: `Rex berkata: Guk guk!`
