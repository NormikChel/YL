# Hızlı başlangıç

## Gereksinimler

- **PHP 8.1+**
- **Composer** — isteğe bağlı
- **Node 18+** — dokümantasyon için

## Kurulum

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## İlk program

`merhaba.yl` oluştur:

```yl
» "Merhaba, dünya!"
```

```bash
php yl.php merhaba.yl
```

## Değişkenler

```yl
¤ isim = "Anna"
¤ yaş = 25
¤ bayrak = ☑
```

## Fonksiyonlar

```yl
§ kare(x) ⟦
    ^ x * x
⟧
```

`^` = `return`.

## REPL

```bash
php yl.php --repl
```

Komutlar: `:help`, `:vars`, `:load <dosya>`, `выход` (çıkış).

## Derleyici

```bash
php ylc.php script.yl script.php
```
