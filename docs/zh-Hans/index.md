---
layout: home

hero:
  name: YL
  text: Yankee Language
  tagline: 基于 PHP 的另类编程语言，用 Unicode 符号当语法。与众不同。OOP、Fiber 生成器、async/await 全都有。
  actions:
    - theme: brand
      text: 快速开始
      link: /zh-Hans/guide/getting-started
    - theme: alt
      text: 语法
      link: /zh-Hans/guide/syntax
    - theme: alt
      text: GitHub
      link: https://github.com/your/yl

features:
  - icon: 🔤
    title: ¤ § λ ⟦ ⟧
    details: 用符号代替关键字。没有 if/else/function/fn — 只有 ¤ ? ¿ ^ § λ。
  - icon: 🏛️
    title: 用 † 继承的 OOP
    details: ‡ 类 † 父类，⋔ 方法，⇢ 实例化，this 在方法体内。真正的类、init、方法重写。
  - icon: 🎯
    title: 闭包 + map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧ — 一等公民的 lambda。map、filter、reduce 直接可用。
  - icon: ⚡
    title: 基于 Fiber 的生成器
    details: ↤ value + ⇶ x = gen ⟦ ⟧ — 真正的 PHP Fiber，不是假的。
  - icon: 🚀
    title: 异步 / await
    details: ⚡ § fn 和 ⏸ await 直接写在语法里。不是库 — 是语法。
  - icon: 📦
    title: 标准库 + JSON + HTTP
    details: prelude、math、list、string、json、datetime、http。40+ 函数自动加载。
  - icon: 🖥️
    title: REPL v4
    details: :vars、:load、多行输入。真正带内置命令的 REPL。
  - icon: 🔨
    title: 编译器 YL → PHP
    details: ylc.php 把 YL 编译成合法 PHP。基础程序原生运行。
  - icon: 🌐
    title: 浏览器 Playground
    details: PHP 服务器 + HTML 编辑器。在浏览器里写 YL，点运行看结果。
---

## 示例

```yl
‡ 动物 ⟦
    ⋔ init(名字 :str) ⟦
        this.名字 = 名字
    ⟧
    ⋔ 叫声() ⟦
        ^ "..."
    ⟧
⟧

‡ 狗 † 动物 ⟦
    ⋔ 叫声() ⟦ ^ "汪！" ⟧
⟧

¤ 小七 = ⇢ 狗("小七")
» 小七.名字 + " 说：" + 小七.叫声()
```

输出：

```
小七 说：汪！
```
