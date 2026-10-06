# 標準ライブラリ

## 自動読み込み: std/prelude.yl

**文字列:** `позиция`, `содержит`, `повтор`, `заменить`
**配列:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**数学:** `факториал`, `gcd`, `even`, `odd`

## 組み込み関数

**汎用:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**文字列:** `upper`, `lower`, `trim`, `split`, `join`
**数学:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**配列:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### 日時

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### ファイル

`readfile`, `writefile`, `appendfile`, `exists`, `read`
