# 시작하기

## 요구사항

- **PHP 8.1+**
- **Composer** — 선택
- **Node 18+** — 문서 빌드용

## 설치

```bash
git clone https://github.com/NormikChel/YL.git
cd YL
```

## 첫 프로그램

`hello.yl` 파일 생성:

```yl
» "안녕, 세상!"
```

```bash
php yl.php hello.yl
```

## 변수

```yl
¤ 이름 = "안나"
¤ 나이 = 25
¤ 플래그 = ☑
```

## 함수

```yl
§ 제곱(x) ⟦
    ^ x * x
⟧
```

`^`는 `return`입니다.

## REPL

```bash
php yl.php --repl
```

명령: `:help`, `:vars`, `:load <파일>`, `выход` (종료).

## 컴파일러

```bash
php ylc.php script.yl script.php
```
