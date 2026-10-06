# 快速开始

## 环境

- PHP 8.1+
- Composer（可选）
- Node 18+（构建本网站）

## 安装

```bash
git clone https://github.com/your/yl.git
cd yl
```

## 第一个程序

新建 `hello.yl`：

```yl
» "你好，世界！"
```

运行：

```bash
php yl.php hello.yl
```

## 变量

```yl
¤ 名字 = "小七"
¤ 年龄 = 25
¤ 标志 = ☑
```

## 函数

```yl
§ 平方(x) ⟦
    ^ x * x
⟧
```

## REPL

```bash
php yl.php --repl
```

命令：`:help`、`:vars`、`:load <文件>`、`выход`。

## Playground

```bash
cd playground
php -S 127.0.0.1:8080
```

## 编译器

```bash
php ylc.php script.yl script.php
```
