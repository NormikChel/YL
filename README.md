# YL - Yankee Language

Esoteric programming language on PHP with unicode syntax.

## Example

```yl
‡ Point ⟦
    ⋔ init(x, y) ⟦ this.x = x; this.y = y ⟧
    ⋔ length() ⟦ ^ sqrt(this.x * this.x + this.y * this.y) ⟧
⟧

¤ p = ⇢ Point(3, 4)
» "Length:", p.length()
```

## Features

- Unique unicode syntax (¤ § λ ⟦ ⟧ ‡ ⋔ ⇢)
- Gradual typing: ¤ x :int = 5
- OOP with † inheritance: ‡ Child † Parent
- Closures: λ (x) ⟦ ^ x * 2 ⟧
- Generators on PHP Fibers: ↤ + ⇶
- Async: ⚡ §, ⏸
- Stdlib: prelude, math, list, string, json, datetime, http
- REPL v4 with :vars, :load, multiline
- Compiler YL->PHP (ylc.php)
- Package manager (ylpkg.php)
- Browser playground (playground/)

## Quick start

```bash
php yl.php examples/main.yl
```

## Docs (i18n)

- Russian: /
- English: /en/
- Simplified Chinese: /zh-Hans/
- Traditional Chinese (Taiwan style): /zh-Hant/

## License

MIT
