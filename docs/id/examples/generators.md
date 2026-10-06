# Generator

Generator pakai **PHP Fiber** asli — thread ringan.

```yl
§ genap(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = genap(10) ⟦
    » "genap:", x
⟧
```

Output:

```
genap: 0
genap: 2
genap: 4
genap: 6
genap: 8
```

## Generator tak terbatas

```yl
§ penghitung() ⟦
    ¤ i = 0
    @ ☑ ⟦
        ↤ i
        i = i + 1
    ⟧
⟧
```
