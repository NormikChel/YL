# 範例

從簡單到進階 der YL 範例。

## Hello world

```yl
~PR~ "安安，世界！"
```

## 類別與繼承

```yl
~CLS~ 動物 ~O~
    ~MET~ init(名字) ~O~ this.名字 = 名字 ~C~
    ~MET~ 叫聲() ~O~ ^ "..." ~C~
~C~

~CLS~ 狗 ~INH~ 動物 ~O~
    ~MET~ 叫聲() ~O~ ^ "汪汪！" ~C~
~C~

~DECL~ 小七 = ~NEW~ 狗("小七")
~PR~ 小七.名字 + " 說：" + 小七.叫聲()
```

## 閉包 + map

```yl
~DECL~ 平方 = map([1, 2, 3, 4], ~LAM~ (x) ~O~ ^ x * x ~C~)
~PR~ 平方
```

更多範例 der：

- [物件導向](/zh-Hant/examples/oop)
- [生成器](/zh-Hant/examples/generators)
- [非同步](/zh-Hant/examples/async)
