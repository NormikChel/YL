---
layout: home

hero:
  name: YL
  text: Yankee Language
  tagline: Эзотерический язык на PHP с юникод-синтаксисом. Ни на что не похож. Работает, компилируется, поддерживает ООП, генераторы на Fibers и async.
  actions:
    - theme: brand
      text: Быстрый старт
      link: /guide/getting-started
    - theme: alt
      text: Синтаксис
      link: /guide/syntax
    - theme: alt
      text: GitHub
      link: https://github.com/your/yl

features:
  - icon: 🔤
    title: ¤ § λ ⟦ ⟧
    details: Уникальные юникод-символы вместо ключевых слов. Никаких if/else/function/fn — только ¤ ? ¿ ^ § λ.
  - icon: 🏛️
    title: ООП с † наследованием
    details: ‡ Класс † Родитель, ⋔ метод, ⇢ создание, this в теле. Полноценные классы, инициализаторы, переопределение методов.
  - icon: 🎯
    title: Замыкания и map/filter
    details: λ (x) ⟦ ^ x * 2 ⟧ — лямбды первого класса. map, filter, reduce работают из коробки.
  - icon: ⚡
    title: Генераторы на Fibers
    details: ↤ value + ⇶ x = gen ⟦ ⟧ — настоящие PHP Fibers. Не имитация, а честные легковесные потоки.
  - icon: 🚀
    title: Async / await
    details: ⚡ § fn и ⏸ await встроены в язык на уровне грамматики. Не библиотека — синтаксис.
  - icon: 📦
    title: Stdlib + JSON + HTTP
    details: prelude, math, list, string, json, datetime, http. 40+ функций, автозагрузка через prelude.yl.
  - icon: 🖥️
    title: REPL v4
    details: :vars, :load, многострочный ввод. Полноценный REPL с историей и встроенными командами.
  - icon: 🔨
    title: Компилятор YL → PHP
    details: ylc.php превращает YL-код в валидный PHP. Базовые программы работают нативно, без интерпретатора.
  - icon: 🌐
    title: Playground в браузере
    details: PHP-сервер + HTML-редактор. Пишешь YL-код в браузере, нажимаешь «Запустить», видишь результат.
---

## Пример

```yl
‡ Животное ⟦
    ⋔ init(имя :str) ⟦
        this.имя = имя
    ⟧
    ⋔ голос() ⟦
        ^ "..."
    ⟧
⟧

‡ Собака † Животное ⟦
    ⋔ голос() ⟦ ^ "Гав!" ⟧
⟧

¤ р = ⇢ Собака("Рекс")
» р.имя + " говорит: " + р.голос()
```

Вывод:

```
Рекс говорит: Гав!
```

## Почему YL?

- **Уникальность.** Ни один известный язык не использует `¤ § λ ⟦ ⟧ ‡ ⋔ ⇢`. Синтаксис узнаётся с первого взгляда.
- **Полнота.** Это не игрушка на 200 строк — тут REPL, компилятор, stdlib, playground, VSCode-расширение.
- **Современность.** Fibers, async/await, генераторы, деструктуризация, gradual typing — всё как во взрослых языках.
- **PHP под капотом.** Работает везде, где есть PHP 8.1+, без зависимостей.
