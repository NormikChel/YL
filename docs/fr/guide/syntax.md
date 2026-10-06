# Syntaxe

## Symboles

| Symbole | Signification |
|---|---|
| `~` | Commentaire |
| `¤` | Déclaration de variable |
| `§` | Fonction |
| `λ` | Lambda |
| `»` | Affichage |
| `⟦ ⟧` | Bloc |
| `?` / `¿` | si / sinon |
| `@` | while |
| `#` | for |
| `⇶` | foreach |
| `^` | return |
| `↤` | yield |
| `‼ ⁇ ⌦` | try / catch / finally |
| `⊕` | import |
| `⊘` / `↻` | break / continue |
| `☑` / `☐` / `∅` | vrai / faux / null |
| `‡` | classe |
| `⋔` | méthode |
| `⇢` | new |
| `†` | héritage |
| `⚡` / `⏸` | async / await |

## Variables

```yl
¤ x = 5
¤ nom = "Anna"
¤ nombres = [1, 2, 3]
¤ personne = ⟪"nom": "Anna", "âge": 25⟫
```

Avec types : `¤ x :int = 5`

## Conditions

```yl
? x > 5 ⟦
    » "plus grand que 5"
⟧ ¿ ⟦
    » "plus petit ou égal"
⟧
```

## Boucles

```yl
@ i < 10 ⟦ i = i + 1 ⟧
# i = 0 .. 10 ⟦ » i ⟧
⇶ x = [1, 2, 3] ⟦ » x ⟧
```

## Fonctions

```yl
§ add(a, b) ⟦ ^ a + b ⟧
```

## Fermetures

```yl
¤ doubler = λ (x) ⟦ ^ x * 2 ⟧
```

## Classes

```yl
‡ Chien ⟦
    ⋔ init(nom) ⟦ this.nom = nom ⟧
    ⋔ cri() ⟦ ^ "Ouaf !" ⟧
⟧

¤ rex = ⇢ Chien("Rex")
```

## Générateurs

```yl
§ pairs(n) ⟦
    # i = 0 .. n ⟦ ? even(i) ⟦ ↤ i ⟧ ⟧
⟧

⇶ x = pairs(10) ⟦ » x ⟧
```

## Async

```yl
⚡ § lent(x) ⟦ ^ x * 2 ⟧
¤ t = lent(21)
» ⏸ t
```

## Gestion d'erreurs

```yl
‼ ⟦ ¤ r = 10 / 0 ⟧ ⁇ e ⟦ » "Attrapé :", e ⟧ ⌦ ⟦ » "finally" ⟧
```
