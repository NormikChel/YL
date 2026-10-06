# Erste Schritte

## Voraussetzungen

- **PHP 8.1+**
- **Composer** — optional
- **Node 18+** — nur für diese Doku

```bash
php -v
```

## Installation

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## Erstes Programm

Datei `hallo.yl` anlegen:

```yl
» "Hallo, Welt!"
```

Ausführen:

```bash
php yl.php hallo.yl
```

## Variablen

```yl
¤ name = "Anna"
¤ alter = 25
¤ flag = ☑
```

## Funktionen

```yl
§ quadrat(x) ⟦
    ^ x * x
⟧
```

`^` bedeutet `return`.

## REPL

```bash
php yl.php --repl
```

Befehle: `:help`, `:vars`, `:load <datei>`, `выход` (Ausstieg).

## Playground

```bash
cd playground
php -S 127.0.0.1:8080
```

## Compiler

```bash
php ylc.php script.yl script.php
```
