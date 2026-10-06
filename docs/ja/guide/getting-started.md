# はじめに

## 必要なもの

- **PHP 8.1+**
- **Composer** — 任意
- **Node 18+** — このドキュメントのビルド用

## インストール

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## 最初のプログラム

`hello.yl` を作成:

```yl
» "こんにちは、世界！"
```

```bash
php yl.php hello.yl
```

## 変数

```yl
¤ 名前 = "アンナ"
¤ 年齢 = 25
¤ フラグ = ☑
```

## 関数

```yl
§ 二乗(x) ⟦
    ^ x * x
⟧
```

`^` は `return` です。

## REPL

```bash
php yl.php --repl
```

コマンド: `:help`、`:vars`、`:load <ファイル>`、`выход`（終了）。

## コンパイラ

```bash
php ylc.php script.yl script.php
```
