<?php
declare(strict_types=1);
$base = __DIR__;

function w(string $rel, string $content): void {
    global $base;
    $path = $base . '/' . $rel;
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    file_put_contents($path, $content);
    echo "  + $rel (" . strlen($content) . " b)\n";
}

echo "Установка root-файлов...\n\n";

w('package.json', '{
  "name": "yl-lang",
  "version": "4.0.0",
  "private": true,
  "description": "YL — Yankee Language, esoteric programming language on PHP",
  "scripts": {
    "docs:dev": "vitepress dev docs",
    "docs:build": "vitepress build docs",
    "docs:preview": "vitepress preview docs"
  },
  "devDependencies": {
    "vitepress": "^1.5.0"
  }
}
');

w('vercel.json', '{
  "$schema": "https://openapi.vercel.sh/vercel.json",
  "buildCommand": "npm run docs:build",
  "outputDirectory": "docs/.vitepress/dist",
  "installCommand": "npm install",
  "framework": null
}
');

w('.gitignore', "# PHP\n/vendor/\ncomposer.lock\n\n# Node / VitePress\nnode_modules/\ndocs/.vitepress/dist/\ndocs/.vitepress/cache/\n.vercel\n\n# YL artefacts\n*.bak\n*.bak2\n*.bak3\nmain_compiled.php\ntest_*_compiled.php\nout.txt\nyl_modules/\nylpkg.json\n\n# OS\n.DS_Store\nThumbs.db\n");

w('LICENSE', "MIT License\n\nCopyright (c) 2026 YL Contributors\n\nPermission is hereby granted, free of charge, to any person obtaining a copy\nof this software and associated documentation files (the \"Software\"), to deal\nin the Software without restriction, including without limitation the rights\nto use, copy, modify, merge, publish, distribute, sublicense, and/or sell\ncopies of the Software, and to permit persons to whom the Software is\nfurnished to do so, subject to the following conditions:\n\nThe above copyright notice and this permission notice shall be included in all\ncopies or substantial portions of the Software.\n\nTHE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR\nIMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,\nFITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE\nAUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER\nLIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,\nOUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE\nSOFTWARE.\n");

w('composer.json', '{
    "name": "yankee/yl",
    "description": "YL — Yankee Language, esoteric programming language on PHP",
    "type": "project",
    "license": "MIT",
    "require": {
        "php": ">=8.1",
        "ext-mbstring": "*",
        "ext-json": "*"
    },
    "bin": ["yl.php"]
}
');

w('README.md', "# YL — Yankee Language\n\nЭзотерический язык программирования на PHP с уникальным юникод-синтаксисом.\n\n## Пример\n\n```yl\n‡ Точка ⟦\n    ⋔ init(x, y) ⟦ this.x = x; this.y = y ⟧\n    ⋔ длина() ⟦ ^ sqrt(this.x * this.x + this.y * this.y) ⟧\n⟧\n\n¤ p = ⇢ Точка(3, 4)\n» \"Длина:\", p.длина()\n```\n\n## Возможности\n\n- Уникальный синтаксис (¤ § λ ⟦ ⟧ ‡ ⋔ ⇢)\n- Gradual typing (¤ x :int = 5)\n- ООП с наследованием (‡ Класс † Родитель)\n- Замыкания (λ (x) ⟦ ^ x * 2 ⟧)\n- Генераторы на PHP Fibers (↤ + ⇶)\n- Асинхронность (⚡ §, ⏸)\n- Stdlib: prelude, math, list, string, json, datetime, http\n- REPL v4\n- Компилятор YL→PHP\n- Пакетный менеджер\n- Playground в браузере\n\n## Быстрый старт\n\n```bash\nphp yl.php examples/main.yl\n```\n\n## Документация\n\n- Русский: `/`\n- English: `/en/`\n- 简体中文: `/zh-Hans/`\n- 繁體中文（臺式）: `/zh-Hant/`\n\n## Лицензия\n\nMIT\n");

echo "\nГотово! Созданы root-файлы.\n";