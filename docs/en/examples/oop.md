# OOP

Classes, inheritance, `this`, method override.

```yl
‡ Point ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ length() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Point(3, 4)
» "Length:", p.length()   ~ 5
```

## Inheritance

```yl
‡ Animal ⟦
    ⋔ init(name :str) ⟦ this.name = name ⟧
    ⋔ sound() ⟦ ^ "..." ⟧
⟧

‡ Dog † Animal ⟦
    ⋔ sound() ⟦ ^ "Woof!" ⟧
⟧

¤ rex = ⇢ Dog("Rex")
» rex.name + " says: " + rex.sound()
```

Output: `Rex says: Woof!`
