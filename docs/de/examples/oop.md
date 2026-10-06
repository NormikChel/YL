# OOP

Klassen, Vererbung, `this`, Methodenüberschreibung.

```yl
‡ Punkt ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ länge() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Punkt(3, 4)
» "Länge:", p.länge()   ~ 5
```

## Vererbung

```yl
‡ Tier ⟦
    ⋔ init(name :str) ⟦ this.name = name ⟧
    ⋔ laut() ⟦ ^ "..." ⟧
⟧

‡ Hund † Tier ⟦
    ⋔ laut() ⟦ ^ "Wuff!" ⟧
⟧

¤ rex = ⇢ Hund("Rex")
» rex.name + " sagt: " + rex.laut()
```

Ausgabe: `Rex sagt: Wuff!`
