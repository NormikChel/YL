# 範例 der

YL 從簡單到進階 der 範例合集。

## Hello world

```yl
» "安安，世界！"
```

## 類別與繼承

```yl
‡ 動物 ⟦
    ⋔ init(名字) ⟦ this.名字 = 名字 ⟧
    ⋔ 叫聲() ⟦ ^ "..." ⟧
⟧

‡ 狗 † 動物 ⟦
    ⋔ 叫聲() ⟦ ^ "汪汪！" ⟧
⟧

¤ 小七 = ⇢ 狗("小七")
» 小七.名字 + " 說：" + 小七.叫聲()
```

## 閉包 + map

```yl
¤ 平方 = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» 平方
```

## 生成器

```yl
§ 偶數(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = 偶數(10) ⟦
    » "偶數：", x
⟧
```

## 非同步

```yl
⚡ § 慢(x) ⟦ ^ x * 2 ⟧
¤ t = 慢(21)
» ⏸ t
```

完整範例在 [GitHub 倉庫](https://github.com/NormikChel/YL/tree/main/examples)。

::: tip 小編碎碎念
這些 code 都嘛可以 copy-paste 下去跑，超方便 der。
:::
