# OOP

Sınıflar, kalıtım, `this`, metot geçersiz kılma.

```yl
‡ Nokta ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ uzunluk() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Nokta(3, 4)
» "Uzunluk:", p.uzunluk()   ~ 5
```

## Kalıtım

```yl
‡ Hayvan ⟦
    ⋔ init(isim :str) ⟦ this.isim = isim ⟧
    ⋔ ses() ⟦ ^ "..." ⟧
⟧

‡ Köpek † Hayvan ⟦
    ⋔ ses() ⟦ ^ "Hav!" ⟧
⟧

¤ rex = ⇢ Köpek("Rex")
» rex.isim + " diyor: " + rex.ses()
```

Çıktı: `Rex diyor: Hav!`
