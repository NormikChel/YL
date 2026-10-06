---
layout: home
hero:
  name: YL
  text: Yankee Language
  tagline: PHP 위에서 돌아가는 유니코드 문법의 난해한 프로그래밍 언어. 어디에도 없는 스타일.
  actions:
    - theme: brand
      text: 시작하기
      link: /ko/guide/getting-started
    - theme: alt
      text: 문법
      link: /ko/guide/syntax
features:
  - title: ¤ § λ ⟦ ⟧
    details: 키워드 대신 유니코드 기호.
  - title: † 상속 OOP
    details: ‡ 클래스 † 부모, ⋔ 메서드, ⇢ new.
  - title: 클로저와 map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧
  - title: Fiber 기반 제너레이터
    details: ↤ value + ⇶ x = gen ⟦ ⟧
  - title: 비동기 ⚡ ⏸
    details: async fn과 await가 언어에 내장.
  - title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http.
---

## 예제

```yl
‡ 동물 ⟦
    ⋔ init(이름 :str) ⟦ this.이름 = 이름 ⟧
    ⋔ 소리() ⟦ ^ "..." ⟧
⟧

‡ 개 † 동물 ⟦
    ⋔ 소리() ⟦ ^ "멍멍!" ⟧
⟧

¤ 멍멍이 = ⇢ 개("멍멍이")
» 멍멍이.이름 + " says: " + 멍멍이.소리()
```

출력: `멍멍이 says: 멍멍!`
