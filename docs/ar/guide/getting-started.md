# البدء السريع

## المتطلبات

- **PHP 8.1+**
- **Composer** — اختياري
- **Node 18+** — لبناء الوثائق

## التثبيت

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## البرنامج الأول

أنشئ `مرحبا.yl`:

```yl
» "مرحباً بالعالم!"
```

```bash
php yl.php مرحبا.yl
```

## المتغيرات

```yl
¤ اسم = "آنا"
¤ عمر = 25
¤ علامة = ☑
```

## الدوال

```yl
§ مربع(x) ⟦
    ^ x * x
⟧
```

`^` تعني `return`.

## REPL

```bash
php yl.php --repl
```

الأوامر: `:help`، `:vars`، `:load <ملف>`، `выход` (خروج).

## المترجم

```bash
php ylc.php script.yl script.php
```
