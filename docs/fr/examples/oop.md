# POO

Classes, héritage, `this`, redéfinition de méthode.

```yl
‡ Point ⟦
    ⋔ init(x, y) ⟦
        this.x = x
        this.y = y
    ⟧
    ⋔ longueur() ⟦
        ^ sqrt(this.x * this.x + this.y * this.y)
    ⟧
⟧

¤ p = ⇢ Point(3, 4)
» "Longueur :", p.longueur()   ~ 5
```

## Héritage

```yl
‡ Animal ⟦
    ⋔ init(nom :str) ⟦ this.nom = nom ⟧
    ⋔ cri() ⟦ ^ "..." ⟧
⟧

‡ Chien † Animal ⟦
    ⋔ cri() ⟦ ^ "Ouaf !" ⟧
⟧

¤ rex = ⇢ Chien("Rex")
» rex.nom + " dit : " + rex.cri()
```

Sortie : `Rex dit : Ouaf !`
