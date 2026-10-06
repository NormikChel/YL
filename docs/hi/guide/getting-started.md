# शुरुआत

## ज़रूरी

- **PHP 8.1+**
- **Composer** — वैकल्पिक
- **Node 18+** — इस डॉक्स के लिए

## इंस्टॉल

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## पहला प्रोग्राम

`नमस्ते.yl` बनाएँ:

```yl
» "नमस्ते, दुनिया!"
```

```bash
php yl.php नमस्ते.yl
```

## वेरिएबल

```yl
¤ नाम = "अन्ना"
¤ उम्र = 25
¤ झंडा = ☑
```

## फ़ंक्शन

```yl
§ वर्ग(x) ⟦
    ^ x * x
⟧
```

`^` का मतलब `return` है।

## REPL

```bash
php yl.php --repl
```

कमांड: `:help`, `:vars`, `:load <फ़ाइल>`, `выход` (बाहर)।

## कंपाइलर

```bash
php ylc.php script.yl script.php
```
