# Sintaks

## Simbol

| Simbol | Arti |
|---|---|
| `~` | Komentar |
| `¤` | Deklarasi variabel |
| `§` | Fungsi |
| `λ` | Lambda |
| `»` | Cetak |
| `⟦ ⟧` | Blok |
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
| `‡` | kelas |
| `⋔` | metode |
| `⇢` | new |
| `†` | pewarisan |
| `⚡` / `⏸` | async / await |

## Variabel

```yl
¤ x = 5
¤ nama = "Anna"
¤ angka = [1, 2, 3]
¤ orang = ⟪"nama": "Anna", "usia": 25⟫
```

Dengan tipe: `¤ x :int = 5`

## Kondisi

```yl
? x > 5 ⟦
    » "lebih dari 5"
⟧ ¿ ⟦
    » "5 atau kurang"
⟧
```

## Perulangan

```yl
@ i < 10 ⟦ i = i + 1 ⟧
# i = 0 .. 10 ⟦ » i ⟧
⇶ x = [1, 2, 3] ⟦ » x ⟧
```

## Fungsi

```yl
§ tambah(a, b) ⟦ ^ a + b ⟧
```

## Closure

```yl
¤ ganda = λ (x) ⟦ ^ x * 2 ⟧
```

## Kelas

```yl
‡ Anjing ⟦
    ⋔ init(nama) ⟦ this.nama = nama ⟧
    ⋔ suara() ⟦ ^ "Guk guk!" ⟧
⟧

¤ rex = ⇢ Anjing("Rex")
```

## Generator

```yl
§ genap(n) ⟦
    # i = 0 .. n ⟦ ? even(i) ⟦ ↤ i ⟧ ⟧
⟧

⇶ x = genap(10) ⟦ » x ⟧
```

## Async

```yl
⚡ § lambat(x) ⟦ ^ x * 2 ⟧
¤ t = lambat(21)
» ⏸ t
```

## Penanganan error

```yl
‼ ⟦ ¤ r = 10 / 0 ⟧ ⁇ e ⟦ » "Tertangkap:", e ⟧ ⌦ ⟦ » "finally" ⟧
```
