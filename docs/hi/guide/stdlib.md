# मानक लाइब्रेरी

## ऑटो-लोड: std/prelude.yl

**स्ट्रिंग:** `позиция`, `содержит`, `повтор`, `заменить`
**सरणी:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**गणित:** `факториал`, `gcd`, `even`, `odd`

## बिल्ट-इन

**सामान्य:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**स्ट्रिंग:** `upper`, `lower`, `trim`, `split`, `join`
**गणित:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**सरणी:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### दिनांक

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### फ़ाइलें

`readfile`, `writefile`, `appendfile`, `exists`, `read`
