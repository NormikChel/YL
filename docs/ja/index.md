---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: PHP 上で動く Unicode 構文の難解プログラミング言語。他に類を見ません。
  actions:
    - theme: brand
      text: はじめに
      link: /ja/guide/getting-started
    - theme: alt
      text: 構文
      link: /ja/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: キーワードの代わりに独自の Unicode 記号。
  - title: † 継承の OOP
    details: ‡ クラス † 親、⋔ メソッド、⇢ new。
  - title: クロージャと map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Fiber ベースのジェネレータ
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: 非同期 ⚡ ⏸
    details: async fn と await を言語に内蔵。
  - title: Stdlib + JSON + HTTP
    details: prelude、math、list、string、json、datetime、http。
---

## 例

```yl
‡ 動物 ⟦
    ⋔ init(名前 :str) ⟦ this.名前 = 名前 ⟧
    ⋔ 鳴き声() ⟦ ^ "..." ⟧
⟧

‡ 犬 † 動物 ⟦
    ⋔ 鳴き声() ⟦ ^ "ワン！" ⟧
⟧

¤ ポチ = ⇢ 犬("ポチ")
» ポチ.名前 + " が言う: " + ポチ.鳴き声()
```

出力: `ポチ が言う: ワン！`
