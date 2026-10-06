---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: Ngôn ngữ lập trình kỳ dị trên PHP với cú pháp Unicode. Không giống bất cứ thứ gì.
  actions:
    - theme: brand
      text: Bắt đầu
      link: /vi/guide/getting-started
    - theme: alt
      text: Cú pháp
      link: /vi/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: Ký hiệu Unicode độc đáo thay vì từ khóa.
  - title: OOP với kế thừa †
    details: ‡ Lớp † Cha, ⋔ phương thức, ⇢ new.
  - title: Closure và map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Generator trên Fiber
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: Bất đồng bộ ⚡ ⏸
    details: async fn và await tích hợp sẵn.
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http.
---

## Ví dụ

```yl
‡ ĐộngVật ⟦
    ⋔ init(tên :str) ⟦ this.tên = tên ⟧
    ⋔ kêu() ⟦ ^ "..." ⟧
⟧

‡ Chó † ĐộngVật ⟦
    ⋔ kêu() ⟦ ^ "Gâu gâu!" ⟧
⟧

¤ milu = ⇢ Chó("Milu")
» milu.tên + " nói: " + milu.kêu()
```

Kết quả: `Milu nói: Gâu gâu!`
