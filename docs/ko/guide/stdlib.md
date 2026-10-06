# 표준 라이브러리

## 자동 로드: std/prelude.yl

**문자열:** `позиция`, `содержит`, `повтор`, `заменить`
**배열:** `сумма`, `произведение`, `среднее`, `сорт`, `уникальные`
**수학:** `факториал`, `gcd`, `even`, `odd`

## 내장 함수

**일반:** `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`
**문자열:** `upper`, `lower`, `trim`, `split`, `join`
**수학:** `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`
**배열:** `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ data = json_parse('{"x": 1}')
» json_str(data)
```

### 날짜

```yl
» сейчас()
» ISO(now())
```

### HTTP

```yl
¤ html = http_get("https://example.com")
```

### 파일

`readfile`, `writefile`, `appendfile`, `exists`, `read`
