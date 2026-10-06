# OOP

```yl
~CLS~ Point ~O~
    ~MET~ init(x, y) ~O~
        this.x = x
        this.y = y
    ~C~
    ~MET~ length() ~O~
        ^ sqrt(this.x * this.x + this.y * this.y)
    ~C~
~C~

~DECL~ p = ~NEW~ Point(3, 4)
~PR~ "Length:", p.length()   ~ 5
```
