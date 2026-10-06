---
layout: home

hero:
  name: YL
  text: Yankee Language
  tagline: Esoteric language on PHP with unicode syntax. Unlike anything else. OOP, Fibers generators, async/await — all in.
  actions:
    - theme: brand
      text: Get started
      link: /en/guide/getting-started
    - theme: alt
      text: Syntax
      link: /en/guide/syntax
    - theme: alt
      text: GitHub
      link: https://github.com/NormikChel/YL

features:
  - icon: 🔤
    title: ¤ § λ ⟦ ⟧
    details: Unique unicode symbols instead of keywords. No if/else/function/fn — only ¤ ? ¿ ^ § λ.
  - icon: 🏛️
    title: OOP with † inheritance
    details: ‡ Class † Parent, ⋔ method, ⇢ new, this inside body. Real classes with init, method override.
  - icon: 🎯
    title: Closures and map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧ — first-class lambdas. map, filter, reduce out of the box.
  - icon: ⚡
    title: Generators on Fibers
    details: ↤ value + ⇶ x = gen ⟦ ⟧ — real PHP Fibers. Not a fake, real lightweight threads.
  - icon: 🚀
    title: Async / await
    details: ⚡ § fn and ⏸ await baked into the grammar. Not a library — syntax.
  - icon: 📦
    title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http. 40+ functions auto-loaded.
  - icon: 🖥️
    title: REPL v4
    details: :vars, :load, multiline input. A real REPL with built-in commands.
  - icon: 🔨
    title: Compiler YL → PHP
    details: ylc.php transpiles YL to valid PHP. Basic programs run natively.
  - icon: 🌐
    title: Browser playground
    details: PHP server + HTML editor. Write YL in browser, hit Run, see output.
---

## Example

```yl
‡ Animal ⟦
    ⋔ init(name :str) ⟦
        this.name = name
    ⟧
    ⋔ sound() ⟦
        ^ "..."
    ⟧
⟧

‡ Dog † Animal ⟦
    ⋔ sound() ⟦ ^ "Woof!" ⟧
⟧

¤ rex = ⇢ Dog("Rex")
» rex.name + " says: " + rex.sound()
```

Output:

```
Rex says: Woof!
```

## Why YL?

- **Unique.** No language uses `¤ § λ ⟦ ⟧ ‡ ⋔ ⇢`. Syntax is recognizable at first sight.
- **Complete.** Not a 200-line toy — REPL, compiler, stdlib, playground, VSCode extension.
- **Modern.** Fibers, async/await, generators, destructuring, gradual typing.
- **PHP underneath.** Runs anywhere PHP 8.1+ is, no dependencies.
