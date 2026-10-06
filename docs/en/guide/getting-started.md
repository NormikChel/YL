# Getting started

## Requirements

- PHP 8.1+
- Composer (optional)
- Node 18+ (for building these docs)

```bash
php -v
```

## Install

```bash
git clone https://github.com/your/yl.git
cd yl
```

## First program

Create `hello.yl`:

```yl
» "Hello, world!"
```

Run:

```bash
php yl.php hello.yl
```

## Variables

```yl
¤ name = "Alice"
¤ age = 25
¤ flag = ☑
```

## Functions

```yl
§ square(x) ⟦
    ^ x * x
⟧
```

## REPL

```bash
php yl.php --repl
```

Commands: `:help`, `:vars`, `:load <file>`, `exit`.

## Playground

```bash
cd playground
php -S 127.0.0.1:8080
```

## Compiler

```bash
php ylc.php script.yl script.php
php script.php
```
