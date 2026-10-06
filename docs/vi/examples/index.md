# Ví dụ

Bộ sưu tập ví dụ YL từ đơn giản đến nâng cao.

## Hello world

```yl
» "Xin chào, thế giới!"
```

## Lớp và kế thừa

```yl
‡ ĐộngVật ⟦
    ⋔ init(tên) ⟦ this.tên = tên ⟧
    ⋔ kêu() ⟦ ^ "..." ⟧
⟧

‡ Chó † ĐộngVật ⟦
    ⋔ kêu() ⟦ ^ "Gâu gâu!" ⟧
⟧

¤ milu = ⇢ Chó("Milu")
» milu.tên + " nói: " + milu.kêu()
```

## Closure và map

```yl
¤ bìnhPhương = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» bìnhPhương
```

## Generator

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

## Bất đồng bộ

```yl
⚡ § chậm(x) ⟦ ^ x * 2 ⟧
¤ t = chậm(21)
» ⏸ t
```

Ví dụ đầy đủ tại [kho GitHub](https://github.com/NormikChel/YL/tree/main/examples).
