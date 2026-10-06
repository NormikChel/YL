# Bibliothèque standard

## Chargée automatiquement : std/prelude.yl

**Chaînes :** `позиция`, `содержит`, `повтор`, `заменить`
**Tableaux :** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**Maths :** `факториал`, `gcd`, `even`, `odd`

## Fonctions intégrées

**Général :** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**Chaînes :** `upper`, `lower`, `trim`, `split`, `join`
**Maths :** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**Tableaux :** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### Date

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### Fichiers

`readfile`, `writefile`, `appendfile`, `exists`, `read`
