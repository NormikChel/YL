# Standard library

## Auto-loaded prelude

Strings: `position`, `contains`, `repeat`, `replace`.
Arrays: `sum`, `product`, `average`, `sort`, `unique`, `max_of`, `min_of`.
Math: `factorial`, `gcd`, `even`, `odd`.

## Built-ins

General: `len`, `str`, `num`, `type`, `assert`, `eval`, `exit`, `dump`, `time`.
Strings: `upper`, `lower`, `trim`, `split`, `join`.
Math: `abs`, `floor`, `ceil`, `round`, `min`, `max`, `sqrt`, `rand`, `range`.
Arrays: `push`, `pop`, `keys`, `vals`, `map`, `filter`, `reduce`.

## JSON

```yl
¤ data = json_parse('{"x": 1}')
» data["x"]
```

## Datetime

```yl
» now()
» ISO(now())
```

## HTTP

```yl
¤ html = http_get("https://example.com")
```

## Files

`readfile`, `writefile`, `appendfile`, `exists`, `read`.

## Extra modules

```yl
⊕ "std/math.yl" as m
⊕ "std/list.yl" as list
⊕ "std/json.yl" as j
⊕ "std/datetime.yl" as dt
```
