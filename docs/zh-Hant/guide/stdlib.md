# 標準庫

## 自動載入 prelude

字串：`position`、`contains`、`repeat`、`replace`。
陣列：`sum`、`product`、`average`、`sort`、`unique`、`max_of`、`min_of`。
數學：`factorial`、`gcd`、`even`、`odd`。

## 內建函式

一般：`len`、`str`、`num`、`type`、`assert`、`eval`、`exit`、`dump`、`time`。
字串：`upper`、`lower`、`trim`、`split`、`join`。
數學：`abs`、`floor`、`ceil`、`round`、`min`、`max`、`sqrt`、`rand`、`range`。
陣列：`push`、`pop`、`keys`、`vals`、`map`、`filter`、`reduce`。

## JSON

```yl
¤ data = json_parse('{"x": 1}')
» data["x"]
```

## 日期時間

```yl
» now()
» ISO(now())
```

## HTTP

```yl
¤ html = http_get("https://example.com")
```

## 檔案

`readfile`、`writefile`、`appendfile`、`exists`、`read`。

## 加碼模組

```yl
⊕ "std/math.yl" as m
⊕ "std/list.yl" as list
⊕ "std/json.yl" as j
⊕ "std/datetime.yl" as dt
```

::: tip 小編碎碎念
這些 module 都嘛可以直接用，超方便的啦。
:::
