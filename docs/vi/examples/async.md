# Bất đồng bộ

`⚡ §` đánh dấu hàm async. `⏸` chờ kết quả.

```yl
⚡ § chậm(x) ⟦
    ^ x * 2
⟧

¤ t = chậm(21)
» "Kết quả:", ⏸ t   ~ 42
```

## Nhiều tác vụ

```yl
⚡ § tính(n) ⟦
    ^ n * n
⟧

¤ a = tính(5)
¤ b = tính(10)
» ⏸ a + ⏸ b   ~ 125
```
