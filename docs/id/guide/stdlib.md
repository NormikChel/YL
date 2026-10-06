# Pustaka standar

## Auto-load: std/prelude.yl

**String:** `позиция`, `содержит`, `повтор`, `заменить`
**Array:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**Matematika:** `факториал`, `gcd`, `even`, `odd`

## Bawaan

**Umum:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**String:** `upper`, `lower`, `trim`, `split`, `join`
**Matematika:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**Array:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### Tanggal

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### File

`readfile`, `writefile`, `appendfile`, `exists`, `read`
