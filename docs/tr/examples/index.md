# Örnekler

Basitten ileri seviyeye YL örnekleri.

## Hello world

```yl
» "Merhaba, dünya!"
```

## Sınıflar ve kalıtım

```yl
‡ Hayvan ⟦
    ⋔ init(isim) ⟦ this.isim = isim ⟧
    ⋔ ses() ⟦ ^ "..." ⟧
⟧

‡ Köpek † Hayvan ⟦
    ⋔ ses() ⟦ ^ "Hav!" ⟧
⟧

¤ rex = ⇢ Köpek("Rex")
» rex.isim + " diyor: " + rex.ses()
```

## Closure ve map

```yl
¤ kareler = map([1, 2, 3, 4], λ (x) ⟦ ^ x * x ⟧)
» kareler
```

## Jeneratörler

```yl
§ çiftler(n) ⟦
    # i = 0 .. n ⟦
        ? even(i) ⟦ ↤ i ⟧
    ⟧
⟧

⇶ x = çiftler(10) ⟦
    » "çift:", x
⟧
```

## Async

```yl
⚡ § yavaş(x) ⟦ ^ x * 2 ⟧
¤ t = yavaş(21)
» ⏸ t
```

Tam örnekler [GitHub deposunda](https://github.com/NormikChel/YL/tree/main/examples).
