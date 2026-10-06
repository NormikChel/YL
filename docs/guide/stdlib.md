# Стандартная библиотека

## Автозагрузка

`std/prelude.yl` подгружается автоматически при каждом запуске. Функции оттуда доступны в любом скрипте.

## Функции из prelude

### Строки

| Функция | Описание |
|---|---|
| `позиция(s, sub)` | Индекс подстроки или -1 |
| `содержит(s, sub)` | `☑` если есть подстрока |
| `повтор(s, n)` | Повторить строку n раз |
| `заменить(s, что, на)` | Замена |

### Массивы

| Функция | Описание |
|---|---|
| `сумма(a)` | Сумма элементов |
| `произведение(a)` | Произведение |
| `среднее(a)` | Среднее арифметическое |
| `сорт(a)` | Отсортированная копия |
| `уникальные(a)` | Уникальные элементы |
| `макс_из(a)` / `мин_из(a)` | Максимум / минимум |

### Математика

| Функция | Описание |
|---|---|
| `факториал(n)` | n! |
| `gcd(a, b)` | НОД |
| `even(x)` / `odd(x)` | Чётность |

## Встроенные (builtins)

### Общие

`len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`

### Строки

`upper`, `lower`, `trim`, `split`, `join`

### Математика

`abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`

### Массивы

`push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`

### JSON

```yl
¤ строка = '{"имя":"Аня","хобби":["код","игры"]}'
¤ obj = json_parse(строка)
» obj["имя"]

¤ обратно = json_str(obj)
¤ красиво = json_str_pretty(obj)
```

### Дата и время

```yl
» сейчас()          ~ 2026-10-06 11:17:45
» сегодня()         ~ 2026-10-06
» ISO(now())        ~ 2026-10-06T11:17:45
» формат(now(), "H:i") ~ 11:17
```

### HTTP

```yl
¤ html = http_get("https://example.com")
¤ ответ = http_post("https://api.example.com", "{\"key\":1}")
```

### Файлы

`readfile`, `writefile`, `appendfile`, `exists`, `read`

## Дополнительные модули

### std/math.yl

```yl
⊕ "std/math.yl" as m
» m.PI
» m.степень(2, 10)
» m.clamp(15, 0, 10)
```

### std/list.yl

```yl
⊕ "std/list.yl" as list
» list.head([1,2,3])
» list.tail([1,2,3])
» list.reverse([1,2,3])
» list.zip([1,2], [3,4])
```

### std/string.yl

```yl
⊕ "std/string.yl" as str
» str.capital("привет")
» str.реверс("hello")
» str.words("a b c")
```

### std/json.yl

```yl
⊕ "std/json.yl" as json
» json.разобрать('{"x":1}')
» json.сериализовать([1,2,3])
```

### std/datetime.yl

```yl
⊕ "std/datetime.yl" as dt
» dt.сейчас()
» dt.ISO(now())
```
