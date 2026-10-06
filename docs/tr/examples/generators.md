# Jeneratörler

Jeneratörler gerçek **PHP Fiber** kullanır — hafif iş parçacıkları.

```yl
§ çiftler(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = çiftler(10) ⟦
    » "çift:", x
⟧
```

Çıktı:

```
çift: 0
çift: 2
çift: 4
çift: 6
çift: 8
```

## Sonsuz jeneratör

```yl
§ sayaç() ⟦
    ¤ i = 0
    @ ☑ ⟦
        ↤ i
        i = i + 1
    ⟧
⟧
```
