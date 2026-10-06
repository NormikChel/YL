# Démarrage rapide

## Prérequis

- **PHP 8.1+**
- **Composer** — optionnel
- **Node 18+** — pour cette doc

## Installation

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## Premier programme

Créez `bonjour.yl` :

```yl
» "Bonjour, monde !"
```

```bash
php yl.php bonjour.yl
```

## Variables

```yl
¤ nom = "Anna"
¤ âge = 25
¤ drapeau = ☑
```

## Fonctions

```yl
§ carré(x) ⟦
    ^ x * x
⟧
```

`^` est `return`.

## REPL

```bash
php yl.php --repl
```

Commandes : `:help`, `:vars`, `:load <fichier>`, `выход` (quitter).

## Compilateur

```bash
php ylc.php script.yl script.php
```
