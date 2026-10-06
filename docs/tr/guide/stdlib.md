# Standart kütüphane

## Otomatik yüklenir: std/prelude.yl

**String:** `позиция`, `содержит`, `повтор`, `заменить`
**Diziler:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**Matematik:** `факториал`, `gcd`, `even`, `odd`

## Yerleşik fonksiyonlar

**Genel:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**String:** `upper`, `lower`, `trim`, `split`, `join`
**Matematik:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**Diziler:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### Tarih

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### Dosyalar

`readfile`, `writefile`, `appendfile`, `exists`, `read`
