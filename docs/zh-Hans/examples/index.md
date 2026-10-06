# 示例

从简单到复杂的 YL 示例。

## Hello world

```yl
~PR~ "你好，世界！"
```

## 类与继承

```yl
~CLS~ 动物 ~O~
    ~MET~ init(名字) ~O~ this.名字 = 名字 ~C~
    ~MET~ 叫声() ~O~ ^ "..." ~C~
~C~

~CLS~ 狗 ~INH~ 动物 ~O~
    ~MET~ 叫声() ~O~ ^ "汪！" ~C~
~C~

~DECL~ 小七 = ~NEW~ 狗("小七")
~PR~ 小七.名字 + " 说：" + 小七.叫声()
```

## 闭包与 map

```yl
~DECL~ 平方 = map([1, 2, 3, 4], ~LAM~ (x) ~O~ ^ x * x ~C~)
~PR~ 平方
```

更多示例：

- [面向对象](/zh-Hans/examples/oop)
- [生成器](/zh-Hans/examples/generators)
- [异步](/zh-Hans/examples/async)
