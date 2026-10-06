# Thư viện chuẩn

## Tự động nạp: std/prelude.yl

**Chuỗi:** `позиция`, `содержит`, `повтор`, `заменить`
**Mảng:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**Toán:** `факториал`, `gcd`, `even`, `odd`

## Hàm tích hợp

**Chung:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**Chuỗi:** `upper`, `lower`, `trim`, `split`, `join`
**Toán:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**Mảng:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### Ngày giờ

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### Tệp

`readfile`, `writefile`, `appendfile`, `exists`, `read`
