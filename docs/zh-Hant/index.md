---
layout: home

hero:
  name: YL
  text: Yankee Language
  tagline: 一個跑在 PHP 上面、語法全部用 Unicode 符號 der 冷門語言。保證你沒看過這種的啦！OOP、Fiber 生成器、async/await 全部都有。
  actions:
    - theme: brand
      text: 立馬開始
      link: /zh-Hant/guide/getting-started
    - theme: alt
      text: 語法 der
      link: /zh-Hant/guide/syntax
    - theme: alt
      text: GitHub
      link: https://github.com/NormikChel/YL

features:
  - icon: 🔤
    title: ¤ § λ ⟦ ⟧
    details: 用符號取代關鍵字，這 code 超帥 der！沒有 if/else/function，只有 ¤ ? ¿ ^ § λ。
  - icon: 🏛️
    title: † 繼承 der OOP
    details: ‡ 類別 † 父類別、⋔ 方法、⇢ 建立物件、this 在方法內底。正港的類別、init、方法覆寫。
  - icon: 🎯
    title: 閉包 + map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧ — 該有的都沒少。map、filter、reduce 直接能用。
  - icon: ⚡
    title: Fiber 做的生成器
    details: ↤ value + ⇶ x = gen ⟦ ⟧ — 正港 PHP Fiber，不是假的啦！
  - icon: 🚀
    title: 非同步 ⚡ ⏸
    details: ⚡ § fn 跟 ⏸ await 直接內建。不是套件 — 是語法本體。ヤバい讚。
  - icon: 📦
    title: 標準庫 + JSON + HTTP
    details: prelude、math、list、string、json、datetime、http。40+ 函式 auto-load。
  - icon: 🖥️
    title: REPL v4
    details: :vars、:load、多行輸入。真正的 REPL，有內建指令 der。
  - icon: 🔨
    title: 編譯器 YL → PHP
    details: ylc.php 把 YL 編譯成合法 PHP。基礎程式直接原生跑。
  - icon: 🌐
    title: 瀏覽器 Playground
    details: PHP 伺服器 + HTML 編輯器。在瀏覽器寫 YL，按下去看 output。
---

## 範例

```yl
‡ 動物 ⟦
    ⋔ init(名字 :str) ⟦
        this.名字 = 名字
    ⟧
    ⋔ 叫聲() ⟦
        ^ "..."
    ⟧
⟧

‡ 狗 † 動物 ⟦
    ⋔ 叫聲() ⟦ ^ "汪汪！" ⟧
⟧

¤ 小七 = ⇢ 狗("小七")
» 小七.名字 + " 說：" + 小七.叫聲()
```

輸出：

```
小七 說：汪汪！
```

::: tip 小編碎碎念
這語言真的母湯，けどう寫起來マジ爽，該有的都沒少，讚 der。
:::
