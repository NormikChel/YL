# 生成器

```yl
~FN~ 偶數(n) ~O~
    # i = 0 .. n ~O~
        ? even(i) ~O~ ~YLD~ i ~C~
    ~C~
~C~

~EACH~ x = 偶數(10) ~O~
    ~PR~ "偶數：", x
~C~
```
