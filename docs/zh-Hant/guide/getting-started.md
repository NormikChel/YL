# 立馬開始

## 環境需求

- PHP 8.1+
- Composer — 可有可無 der
- Node 18+ — 只有要 build 這個網站才需要

```bash
php -v
```

## 裝起來！

```bash
git clone https://github.com/NormikChel/YL.git
cd yl
```

## 第一個程式

開個檔案 `hello.yl`：

```yl
» "安安，世界！"
```

Run 下去：

```bash
php yl.php hello.yl
```

## 變數

```yl
¤ 名字 = "小七"
¤ 年紀 = 25
¤ 是不是帥哥 = ☑
```

## 函式

```yl
§ 平方(x) ⟦
    ^ x * x
⟧
```

## REPL

```bash
php yl.php --repl
```

指令：`:help`、`:vars`、`:load <檔>`、`выход`（掰掰啦）。

## Playground

```bash
cd playground
php -S 127.0.0.1:8080
```

打開瀏覽器 `http://127.0.0.1:8080`，左邊寫 code、右邊看 output。

## 編譯器

```bash
php ylc.php script.yl script.php
```

把 YL 編譯成合法 PHP。けどう OOP、模組、eval 母湯。
