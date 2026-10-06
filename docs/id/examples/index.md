# Contoh

Koleksi contoh YL dari sederhana hingga lanjutan.

## Hello world

```yl
» "Halo, dunia!"
```

## Kelas dan pewarisan

```yl
‡ Hewan ⟦
    ⋔ init(nama) ⟦ this.nama = nama ⟧
    ⋔ suara() ⟦ ^ "..." ⟧
⟧

‡ Anjing † Hewan ⟦
    ⋔ suara() ⟦ ^ "Guk guk!" ⟧
⟧

¤ rex = ⇢ Anjing("Rex")
» rex.nama + " berkata: " + rex.suara()
```

## Closure dan map

```yl
¤ kuadrat = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» kuadrat
```

## Generator

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

## Async

```yl
⚡ § lambat(x) ⟦ ^ x * 2 ⟧
¤ t = lambat(21)
» ⏸ t
```

Contoh lengkap di [repositori GitHub](https://github.com/NormikChel/YL/tree/main/examples).
