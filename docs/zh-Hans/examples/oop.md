# 面向对象

```yl
~CLS~ 点 ~O~
    ~MET~ init(x, y) ~O~
        this.x = x
        this.y = y
    ~C~
    ~MET~ 长度() ~O~
        ^ sqrt(this.x * this.x + this.y * this.y)
    ~C~
~C~

~DECL~ p = ~NEW~ 点(3, 4)
~PR~ "长度：", p.长度()   ~ 5
```
