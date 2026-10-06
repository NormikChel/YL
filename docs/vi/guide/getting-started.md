# Bắt đầu

## Yêu cầu

- **PHP 8.1+**
- **Composer** — tùy chọn
- **Node 18+** — để build docs

## Cài đặt

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## Chương trình đầu tiên

Tạo `xin_chao.yl`:

```yl
» "Xin chào, thế giới!"
```

```bash
php yl.php xin_chao.yl
```

## Biến

```yl
¤ tên = "An"
¤ tuổi = 25
¤ cờ = ☑
```

## Hàm

```yl
§ bìnhPhương(x) ⟦
    ^ x * x
⟧
```

`^` là `return`.

## REPL

```bash
php yl.php --repl
```

Lệnh: `:help`, `:vars`, `:load <tệp>`, `выход` (thoát).

## Trình biên dịch

```bash
php ylc.php script.yl script.php
```
