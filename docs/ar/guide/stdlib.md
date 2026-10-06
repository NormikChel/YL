# المكتبة القياسية

## تحميل تلقائي: std/prelude.yl

**نصوص:** `позиция`, `содержит`, `повтор`, `заменить`
**مصفوفات:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**رياضيات:** `факториал`, `gcd`, `even`, `odd`

## دوال مدمجة

**عام:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**نصوص:** `upper`, `lower`, `trim`, `split`, `join`
**رياضيات:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**مصفوفات:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### التاريخ

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### الملفات

`readfile`, `writefile`, `appendfile`, `exists`, `read`
