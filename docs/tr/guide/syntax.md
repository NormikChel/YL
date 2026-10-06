# Sözdizimi

## Semboller

| Sembol | Anlam |
|---|---|
| `~` | Yorum |
| `¤` | Değişken |
| `§` | Fonksiyon |
| `λ` | Lambda |
| `»` | Yazdır |
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
| `☑` / `☐` / `∅` | doğru / yanlış / null |
| `‡` | sınıf |
| `⋔` | metot |
| `⇢` | new |
| `†` | kalıtım |
| `⚡` / `⏸` | async / await |

## Değişkenler

```yl
¤ x = 5
¤ isim = "Anna"
¤ sayılar = [1, 2, 3]
¤ kişi = ⟪"isim": "Anna", "yaş": 25⟫
```

Tipli: `¤ x :int = 5`

## Koşullar

```yl
? x > 5 ⟦
    » "5'ten büyük"
⟧ ¿ ⟦
    » "5 veya daha küçük"
⟧
```

## Döngüler

```yl
@ i < 10 ⟦ i = i + 1 ⟧
# i = 0 .. 10 ⟦ » i ⟧
⇶ x = [1, 2, 3] ⟦ » x ⟧
```

## Fonksiyonlar

```yl
§ topla(a, b) ⟦ ^ a + b ⟧
```

## Closure

```yl
¤ ikiKat = λ (x) ⟦ ^ x * 2 ⟧
```

## Sınıflar

```yl
‡ Köpek ⟦
    ⋔ init(isim) ⟦ this.isim = isim ⟧
    ⋔ ses() ⟦ ^ "Hav!" ⟧
⟧

¤ rex = ⇢ Köpek("Rex")
```

## Jeneratörler

```yl
§ çiftler(n) ⟦
    # i = 0 .. n ⟦ ? even(i) ⟦ ↤ i ⟧ ⟧
⟧

⇶ x = çiftler(10) ⟦ » x ⟧
```

## Async

```yl
⚡ § yavaş(x) ⟦ ^ x * 2 ⟧
¤ t = yavaş(21)
» ⏸ t
```

## Hata yönetimi

```yl
‼ ⟦ ¤ r = 10 / 0 ⟧ ⁇ e ⟦ » "Yakalandı:", e ⟧ ⌦ ⟦ » "finally" ⟧
```
