# Generator

Generator dùng **PHP Fiber** thật — luồng nhẹ.

```yl
§ sốChẵn(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = sốChẵn(10) ⟦
    » "chẵn:", x
⟧
```

Kết quả:

```
chẵn: 0
chẵn: 2
chẵn: 4
chẵn: 6
chẵn: 8
```

## Generator vô hạn

```yl
§ đếm() ⟦
    ¤ i = 0
    @ ☑ ⟦
        ↤ i
        i = i + 1
    ⟧
⟧
```
