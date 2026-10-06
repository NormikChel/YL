# Mulai cepat

## Persyaratan

- **PHP 8.1+**
- **Composer** — opsional
- **Node 18+** — untuk build dokumen

## Instalasi

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## Program pertama

Buat `halo.yl`:

```yl
» "Halo, dunia!"
```

```bash
php yl.php halo.yl
```

## Variabel

```yl
¤ nama = "Anna"
¤ usia = 25
¤ bendera = ☑
```

## Fungsi

```yl
§ kuadrat(x) ⟦
    ^ x * x
⟧
```

`^` adalah `return`.

## REPL

```bash
php yl.php --repl
```

Perintah: `:help`, `:vars`, `:load <file>`, `выход` (keluar).

## Kompilator

```bash
php ylc.php script.yl script.php
```
