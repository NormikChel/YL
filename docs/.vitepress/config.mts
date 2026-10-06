import { defineConfig } from 'vitepress'

const ylGrammar = {
  name: 'yl',
  scopeName: 'source.yl',
  patterns: [
    { include: '#keywords' }, { include: '#strings' },
    { include: '#comments' }, { include: '#numbers' },
    { include: '#operators' },
  ],
  repository: {
    keywords: { patterns: [{ name: 'keyword.control.yl', match: '[\u00A4\u00A7\u03BB\u00BB\u27E6\u27E7\u00BF\u21F6\u21A4\u2021\u22D4\u21E2\u2020\u26A1\u23F8\u2611\u2610\u2205\u203C\u2047\u2326\u2295\u27EA\u27EB\u2298\u21BB\u2261]' }] },
    strings: { patterns: [
      { name: 'string.quoted.double.yl', begin: '"', end: '"' },
      { name: 'string.quoted.single.yl', begin: "'", end: "'" },
    ]},
    comments: { patterns: [{ name: 'comment.line.tilde.yl', match: '~.*$' }] },
    numbers: { patterns: [{ name: 'constant.numeric.yl', match: '[0-9]+' }] },
    operators: { patterns: [{ name: 'keyword.operator.yl', match: '[-+*/%<>=!&|.]' }] },
  },
}

export default defineConfig({
  title: 'YL',
  description: 'Yankee Language — эзотерический язык на PHP с юникод-синтаксисом',
  cleanUrls: true,
  head: [
    ['link', { rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' }],
    ['meta', { name: 'theme-color', content: '#a78bfa' }],
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:title', content: 'YL — Yankee Language' }],
  ],
  markdown: { languages: [ylGrammar] },
  themeConfig: {
    logo: '/logo.svg',
    siteTitle: 'YL',
    socialLinks: [
      { icon: 'github', link: 'https://github.com/your/yl' },
    ],
    search: {
      provider: 'local',
      options: {
        translations: {
          button: { buttonText: 'Поиск', buttonAriaLabel: 'Поиск' },
          modal: {
            noResultsText: 'Ничего не найдено',
            resetButtonTitle: 'Сбросить',
            footer: { selectText: 'выбрать', navigateText: 'перемещаться', closeText: 'закрыть' },
          },
        },
      },
    },
    footer: {
      message: 'Сделано на PHP. Лицензия MIT.',
      copyright: '© 2026 YL Contributors',
    },
    docFooter: { prev: 'Назад', next: 'Вперёд' },
    darkModeSwitchLabel: 'Тема',
    sidebarMenuLabel: 'Меню',
    returnToTopLabel: 'Наверх',
    outline: { label: 'На этой странице', level: [2, 3] },
    editLink: {
      pattern: 'https://github.com/your/yl/edit/main/docs/:path',
      text: 'Редактировать на GitHub',
    },
    lastUpdated: { text: 'Обновлено' },
  },
  locales: {
    root: {
      label: 'Русский', lang: 'ru',
      themeConfig: {
        nav: [
          { text: 'Руководство', link: '/guide/getting-started', activeMatch: '/guide/' },
          { text: 'Синтаксис', link: '/guide/syntax' },
          { text: 'Stdlib', link: '/guide/stdlib' },
          { text: 'Примеры', link: '/examples/' },
          { text: 'Playground', link: 'https://github.com/your/yl/tree/main/playground' },
        ],
        sidebar: {
          '/guide/': [{ text: 'Руководство', items: [
            { text: 'Быстрый старт', link: '/guide/getting-started' },
            { text: 'Синтаксис', link: '/guide/syntax' },
            { text: 'Стандартная библиотека', link: '/guide/stdlib' },
          ]}],
          '/examples/': [{ text: 'Примеры', items: [
            { text: 'Всё сразу', link: '/examples/' },
            { text: 'ООП', link: '/examples/oop' },
            { text: 'Генераторы', link: '/examples/generators' },
            { text: 'Async', link: '/examples/async' },
          ]}],
        },
      },
    },
    en: {
      label: 'English', lang: 'en', link: '/en/',
      themeConfig: {
        nav: [
          { text: 'Guide', link: '/en/guide/getting-started', activeMatch: '/en/guide/' },
          { text: 'Syntax', link: '/en/guide/syntax' },
          { text: 'Stdlib', link: '/en/guide/stdlib' },
          { text: 'Examples', link: '/en/examples/' },
          { text: 'Playground', link: 'https://github.com/your/yl' },
        ],
        sidebar: {
          '/en/guide/': [{ text: 'Guide', items: [
            { text: 'Getting started', link: '/en/guide/getting-started' },
            { text: 'Syntax', link: '/en/guide/syntax' },
            { text: 'Standard library', link: '/en/guide/stdlib' },
          ]}],
        },
      },
    },
    'zh-Hans': {
      label: '简体中文', lang: 'zh-Hans', link: '/zh-Hans/',
      themeConfig: {
        nav: [
          { text: '指南', link: '/zh-Hans/guide/getting-started' },
          { text: '语法', link: '/zh-Hans/guide/syntax' },
          { text: '标准库', link: '/zh-Hans/guide/stdlib' },
        ],
        sidebar: {
          '/zh-Hans/guide/': [{ text: '指南', items: [
            { text: '快速开始', link: '/zh-Hans/guide/getting-started' },
            { text: '语法', link: '/zh-Hans/guide/syntax' },
            { text: '标准库', link: '/zh-Hans/guide/stdlib' },
          ]}],
        },
      },
    },
    'zh-Hant': {
      label: '繁體中文（臺式）', lang: 'zh-Hant', link: '/zh-Hant/',
      themeConfig: {
        nav: [
          { text: '指南 der', link: '/zh-Hant/guide/getting-started' },
          { text: '語法', link: '/zh-Hant/guide/syntax' },
          { text: '標準庫', link: '/zh-Hant/guide/stdlib' },
        ],
        sidebar: {
          '/zh-Hant/guide/': [{ text: '指南', items: [
            { text: '立馬開始', link: '/zh-Hant/guide/getting-started' },
            { text: '語法 der', link: '/zh-Hant/guide/syntax' },
            { text: '標準庫', link: '/zh-Hant/guide/stdlib' },
          ]}],
        },
      },
    },
  },
})
