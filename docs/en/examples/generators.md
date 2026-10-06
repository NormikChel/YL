# Generators

```yl
~FN~ evens(n) ~O~
    # i = 0 .. n ~O~
        ? even(i) ~O~ ~YLD~ i ~C~
    ~C~
~C~

~EACH~ x = evens(10) ~O~
    ~PR~ "even:", x
~C~
```
