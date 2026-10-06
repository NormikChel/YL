---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: PHP पर बनी यूनिकोड सिंटैक्स वाली एक विचित्र प्रोग्रामिंग भाषा। किसी और जैसी नहीं।
  actions:
    - theme: brand
      text: शुरू करें
      link: /hi/guide/getting-started
    - theme: alt
      text: सिंटैक्स
      link: /hi/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: कीवर्ड की जगह अनोखे यूनिकोड चिह्न।
  - title: † विरासत के साथ OOP
    details: ‡ क्लास † पैरेंट, ⋔ मेथड, ⇢ new।
  - title: क्लोज़र और map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Fiber पर जेनरेटर
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: Async ⚡ ⏸
    details: async fn और await भाषा में अंतर्निहित।
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http।
---

## उदाहरण

```yl
‡ जानवर ⟦
    ⋔ init(नाम :str) ⟦ this.नाम = नाम ⟧
    ⋔ आवाज़() ⟦ ^ "..." ⟧
⟧

‡ कुत्ता † जानवर ⟦
    ⋔ आवाज़() ⟦ ^ "भौं भौं!" ⟧
⟧

¤ शेरू = ⇢ कुत्ता("शेरू")
» शेरू.नाम + " बोला: " + शेरू.आवाज़()
```

आउटपुट: `शेरू बोला: भौं भौं!`
