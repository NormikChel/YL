# 物件導向

```yl
~CLS~ 點 ~O~
    ~MET~ init(x, y) ~O~
        this.x = x
        this.y = y
    ~C~
    ~MET~ 長度() ~O~
        ^ sqrt(this.x * this.x + this.y * this.y)
    ~C~
~C~

~DECL~ p = ~NEW~ 點(3, 4)
~PR~ "長度：", p.長度()   ~ 5
```
