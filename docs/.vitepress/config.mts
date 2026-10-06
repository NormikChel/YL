import { defineConfig } from 'vitepress'

const SITE = 'https://yankeelanguage.vercel.app'
const OG_IMG = SITE + '/og-cover.svg'
const GH = 'https://github.com/NormikChel/YL'

const ylGrammar = {
  name: 'yl',
  scopeName: 'source.yl',
  patterns: [
    { include: '#keywords' }, { include: '#strings' },
    { include: '#comments' }, { include: '#numbers' },
    { include: '#operators' },
  ],
  repository: {
    keywords: { patterns: [{ name: 'keyword.control.yl', match: '[\\u00A4\\u00A7\\u03BB\\u00BB\\u27E6\\u27E7\\u00BF\\u21F6\\u21A4\\u2021\\u22D4\\u21E2\\u2020\\u26A1\\u23F8\\u2611\\u2610\\u2205\\u203C\\u2047\\u2326\\u2295\\u27EA\\u27EB\\u2298\\u21BB\\u2261]' }] },
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
  description: 'Yankee Language - esoteric programming language on PHP with unicode syntax',
  cleanUrls: true,
  lang: 'ru',
  sitemap: {
    hostname: SITE,
    lastmodDateOnly: true,
  },
  head: [
    // Viewport + mobile
    ['meta', { name: 'viewport', content: 'width=device-width, initial-scale=1.0, viewport-fit=cover' }],
    ['meta', { name: 'theme-color', content: '#a78bfa', media: '(prefers-color-scheme: light)' }],
    ['meta', { name: 'theme-color', content: '#0f0f17', media: '(prefers-color-scheme: dark)' }],
    ['meta', { name: 'color-scheme', content: 'dark light' }],

    // Icons + PWA
    ['link', { rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' }],
    ['link', { rel: 'apple-touch-icon', href: '/apple-touch-icon.svg' }],
    ['link', { rel: 'manifest', href: '/manifest.webmanifest' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-title', content: 'YL' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black-translucent' }],
    ['meta', { name: 'mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'application-name', content: 'YL' }],
    ['meta', { name: 'msapplication-TileColor', content: '#a78bfa' }],

    // SEO basic
    ['meta', { name: 'author', content: 'NormikChel' }],
    ['meta', { name: 'keywords', content: 'YL, Yankee Language, esoteric programming language, PHP, unicode syntax, transpiler, interpreter, OOP, fibers, async, генератор, компилятор' }],
    ['meta', { name: 'robots', content: 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' }],
    ['meta', { name: 'googlebot', content: 'index, follow' }],
    ['link', { rel: 'canonical', href: SITE + '/' }],
    ['link', { rel: 'alternate', hreflang: 'ru', href: SITE + '/' }],
    ['link', { rel: 'alternate', hreflang: 'en', href: SITE + '/en/' }],
    ['link', { rel: 'alternate', hreflang: 'zh-Hans', href: SITE + '/zh-Hans/' }],
    ['link', { rel: 'alternate', hreflang: 'zh-Hant', href: SITE + '/zh-Hant/' }],
    ['link', { rel: 'alternate', hreflang: 'x-default', href: SITE + '/' }],

    // Feeds
    ['link', { rel: 'alternate', type: 'application/rss+xml', title: 'YL RSS', href: SITE + '/rss.xml' }],
    ['link', { rel: 'alternate', type: 'application/atom+xml', title: 'YL Atom', href: SITE + '/atom.xml' }],
    ['link', { rel: 'sitemap', type: 'application/xml', href: SITE + '/sitemap.xml' }],

    // Open Graph
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:site_name', content: 'YL - Yankee Language' }],
    ['meta', { property: 'og:title', content: 'YL - Yankee Language' }],
    ['meta', { property: 'og:description', content: 'Эзотерический язык программирования на PHP с уникальным юникод-синтаксисом. ООП, генераторы на Fibers, async/await.' }],
    ['meta', { property: 'og:url', content: SITE + '/' }],
    ['meta', { property: 'og:image', content: OG_IMG }],
    ['meta', { property: 'og:image:width', content: '1200' }],
    ['meta', { property: 'og:image:height', content: '630' }],
    ['meta', { property: 'og:image:alt', content: 'YL - Yankee Language' }],
    ['meta', { property: 'og:locale', content: 'ru_RU' }],
    ['meta', { property: 'og:locale:alternate', content: 'en_US' }],
    ['meta', { property: 'og:locale:alternate', content: 'zh_CN' }],
    ['meta', { property: 'og:locale:alternate', content: 'zh_TW' }],

    // Twitter / X
    ['meta', { name: 'twitter:card', content: 'summary_large_image' }],
    ['meta', { name: 'twitter:site', content: '@NormikChel' }],
    ['meta', { name: 'twitter:creator', content: '@NormikChel' }],
    ['meta', { name: 'twitter:title', content: 'YL - Yankee Language' }],
    ['meta', { name: 'twitter:description', content: 'Esoteric language on PHP with unicode syntax' }],
    ['meta', { name: 'twitter:image', content: OG_IMG }],
    ['meta', { name: 'twitter:image:alt', content: 'YL - Yankee Language' }],

    // Facebook / VK / Telegram / WhatsApp
    ['meta', { property: 'fb:app_id', content: '' }],

    // LinkedIn
    ['meta', { property: 'linkedin:owner', content: 'NormikChel' }],

    // Discord rich embed
    ['meta', { property: 'og:image:type', content: 'image/svg+xml' }],

    // Schema.org JSON-LD (WebSite + SoftwareApplication + SearchAction)
    ['script', { type: 'application/ld+json' }, JSON.stringify({
      '@context': 'https://schema.org',
      '@graph': [
        {
          '@type': 'WebSite',
          '@id': SITE + '/#website',
          url: SITE + '/',
          name: 'YL - Yankee Language',
          description: 'Esoteric programming language on PHP with unicode syntax',
          inLanguage: ['ru', 'en', 'zh-Hans', 'zh-Hant'],
          publisher: { '@id': SITE + '/#person' },
          potentialAction: {
            '@type': 'SearchAction',
            target: { '@type': 'EntryPoint', urlTemplate: SITE + '/?q={search_term_string}' },
            'query-input': 'required name=search_term_string',
          },
        },
        {
          '@type': 'Person',
          '@id': SITE + '/#person',
          name: 'NormikChel',
          url: 'https://github.com/NormikChel',
          sameAs: ['https://github.com/NormikChel/YL'],
        },
        {
          '@type': 'SoftwareApplication',
          '@id': SITE + '/#app',
          name: 'YL',
          alternateName: 'Yankee Language',
          applicationCategory: 'DeveloperApplication',
          operatingSystem: 'Cross-platform (PHP 8.1+)',
          programmingLanguage: ['PHP', 'Yankee'],
          license: 'https://opensource.org/licenses/MIT',
          offers: { '@type': 'Offer', price: '0', priceCurrency: 'USD' },
          codeRepository: GH,
          softwareVersion: '4.0.0',
          author: { '@id': SITE + '/#person' },
          description: 'Esoteric programming language with unique unicode syntax.',
        },
        {
          '@type': 'SoftwareSourceCode',
          '@id': SITE + '/#source',
          name: 'YL',
          codeRepository: GH,
          programmingLanguage: 'PHP',
          license: 'https://opensource.org/licenses/MIT',
          author: { '@id': SITE + '/#person' },
        },
        {
          '@type': 'BreadcrumbList',
          '@id': SITE + '/#breadcrumb',
          itemListElement: [
            { '@type': 'ListItem', position: 1, name: 'Home', item: SITE + '/' },
            { '@type': 'ListItem', position: 2, name: 'Guide', item: SITE + '/guide/getting-started' },
          ],
        },
      ],
    })],
  ],
  markdown: { languages: [ylGrammar] },
  themeConfig: {
    logo: '/logo.svg',
    siteTitle: 'YL',
    socialLinks: [
      { icon: 'github', link: GH },
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
      pattern: GH + '/edit/main/docs/:path',
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
          { text: 'Playground', link: GH + '/tree/main/playground' },
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
          { text: 'Playground', link: GH },
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