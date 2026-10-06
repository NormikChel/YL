# Standardbibliothek

## Automatisch geladen: std/prelude.yl

**Strings:** `позиция`, `содержит`, `повтор`, `заменить`
**Arrays:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`, `макс_из`, `мин_из`
**Mathe:** `факториал`, `gcd`, `even`, `odd`

## Eingebaute Funktionen

**Allgemein:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**Strings:** `upper`, `lower`, `trim`, `split`, `join`
**Mathe:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**Arrays:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### Datum

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### Dateien

`readfile`, `writefile`, `appendfile`, `exists`, `read`
