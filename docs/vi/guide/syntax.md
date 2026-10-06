# Cú pháp

## Ký hiệu

| Ký hiệu | Ý nghĩa |
|---|---|
| `~` | Chú thích |
| `¤` | Khai báo biến |
| `§` | Hàm |
| `λ` | Lambda |
| `»` | In |
| `⟦ ⟧` | Khối |
| `?` / `¿` | if / else |
| `@` | while |
| `#` | for |
| `⇶` | foreach |
| `^` | return |
| `↤` | yield |
| `‼ ⁇ ⌦` | try / catch / finally |
| `⊕` | import |
| `⊘` / `↻` | break / continue |
| `☑` / `☐` / `∅` | true / false / null |
| `‡` | lớp |
| `⋔` | phương thức |
| `⇢` | new |
| `†` | kế thừa |
| `⚡` / `⏸` | async / await |

## Biến

```yl
¤ x = 5
¤ tên = "An"
¤ số = [1, 2, 3]
¤ người = ⟪"tên": "An", "tuổi": 25⟫
```

Có kiểu: `¤ x :int = 5`

## Điều kiện

```yl
? x > 5 ⟦
    » "lớn hơn 5"
⟧ ¿ ⟦
    » "không lớn hơn"
⟧
```

## Vòng lặp

```yl
@ i < 10 ⟦ i = i + 1 ⟧
# i = 0 .. 10 ⟦ » i ⟧
⇶ x = [1, 2, 3] ⟦ » x ⟧
```

## Hàm

```yl
§ cộng(a, b) ⟦ ^ a + b ⟧
```

## Closure

```yl
¤ gấpĐôi = λ (x) ⟦ ^ x * 2 ⟧
```

## Lớp

```yl
‡ Chó ⟦
    ⋔ init(tên) ⟦ this.tên = tên ⟧
    ⋔ sủa() ⟦ ^ "Gâu gâu!" ⟧
⟧

¤ milu = ⇢ Chó("Milu")
```

## Generator

```yl
§ sốChẵn(n) ⟦
    # i = 0 .. n ⟦ ? even(i) ⟦ ↤ i ⟧ ⟧
⟧

⇶ x = sốChẵn(10) ⟦ » x ⟧
```

## Bất đồng bộ

```yl
⚡ § chậm(x) ⟦ ^ x * 2 ⟧
¤ t = chậm(21)
» ⏸ t
```

## Xử lý lỗi

```yl
‼ ⟦ ¤ r = 10 / 0 ⟧ ⁇ e ⟦ » "Bắt được:", e ⟧ ⌦ ⟦ » "finally" ⟧
```
