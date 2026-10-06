# 标准库

## 自动加载 prelude

字符串：`position`、`contains`、`repeat`、`replace`。
数组：`sum`、`product`、`average`、`sort`、`unique`、`max_of`、`min_of`。
数学：`factorial`、`gcd`、`even`、`odd`。

## 内置函数

通用：`len`、`str`、`num`、`type`、`assert`、`eval`、`exit`、`dump`、`time`。
字符串：`upper`、`lower`、`trim`、`split`、`join`。
数学：`abs`、`floor`、`ceil`、`round`、`min`、`max`、`sqrt`、`rand`、`range`。
数组：`push`、`pop`、`keys`、`vals`、`map`、`filter`、`reduce`。

## JSON

```yl
¤ data = json_parse('{"x": 1}')
» data["x"]
```

## 日期时间

```yl
» now()
» ISO(now())
```

## HTTP

```yl
¤ html = http_get("https://example.com")
```

## 文件

`readfile`、`writefile`、`appendfile`、`exists`、`read`。

## 额外模块

```yl
⊕ "std/math.yl" as m
⊕ "std/list.yl" as list
⊕ "std/json.yl" as j
⊕ "std/datetime.yl" as dt
```
