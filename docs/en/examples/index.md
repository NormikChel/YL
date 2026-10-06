# Examples

A collection of YL examples from simple to advanced.

## Hello world

```yl
~PR~ "Hello, world!"
```

## Classes and inheritance

```yl
~CLS~ Animal ~O~
    ~MET~ init(name) ~O~ this.name = name ~C~
    ~MET~ sound() ~O~ ^ "..." ~C~
~C~

~CLS~ Dog ~INH~ Animal ~O~
    ~MET~ sound() ~O~ ^ "Woof!" ~C~
~C~

~DECL~ rex = ~NEW~ Dog("Rex")
~PR~ rex.name + " says: " + rex.sound()
```

## Closures and map

```yl
~DECL~ squares = map([1, 2, 3, 4], ~LAM~ (x) ~O~ ^ x * x ~C~)
~PR~ squares
```

Full examples:

- [OOP](/en/examples/oop)
- [Generators](/en/examples/generators)
- [Async](/en/examples/async)
