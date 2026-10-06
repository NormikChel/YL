# 生成器

```yl
~FN~ 偶数(n) ~O~
    # i = 0 .. n ~O~
        ? even(i) ~O~ ~YLD~ i ~C~
    ~C~
~C~

~EACH~ x = 偶数(10) ~O~
    ~PR~ "偶数：", x
~C~
```
