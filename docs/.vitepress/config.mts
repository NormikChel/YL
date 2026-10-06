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

const searchRu = {
  button: { buttonText: 'Поиск', buttonAriaLabel: 'Поиск по сайту' },
  modal: {
    displayDetails: 'Развернуть детали',
    resetButtonTitle: 'Сбросить',
    backButtonTitle: 'Закрыть',
    noResultsText: 'Ничего не найдено',
    footer: {
      selectText: 'выбрать', selectKeyAriaLabel: 'выбрать',
      navigateText: 'перемещаться', navigateUpKeyAriaLabel: 'вверх', navigateDownKeyAriaLabel: 'вниз',
      closeText: 'закрыть', closeKeyAriaLabel: 'закрыть',
    },
  },
}
const searchEn = {
  button: { buttonText: 'Search', buttonAriaLabel: 'Search documentation' },
  modal: {
    displayDetails: 'Display detailed list',
    resetButtonTitle: 'Reset search',
    backButtonTitle: 'Close search',
    noResultsText: 'No results for',
    footer: {
      selectText: 'to select', selectKeyAriaLabel: 'Enter key',
      navigateText: 'to navigate', navigateUpKeyAriaLabel: 'Arrow up', navigateDownKeyAriaLabel: 'Arrow down',
      closeText: 'to close', closeKeyAriaLabel: 'Escape key',
    },
  },
}
const searchZhHans = {
  button: { buttonText: '搜索', buttonAriaLabel: '搜索文档' },
  modal: {
    displayDetails: '显示详情', resetButtonTitle: '清除查询条件', backButtonTitle: '返回',
    noResultsText: '无搜索结果',
    footer: {
      selectText: '选择', selectKeyAriaLabel: '回车键',
      navigateText: '切换', navigateUpKeyAriaLabel: '上箭头', navigateDownKeyAriaLabel: '下箭头',
      closeText: '关闭', closeKeyAriaLabel: 'Esc 键',
    },
  },
}
const searchZhHant = {
  button: { buttonText: '搜尋 der', buttonAriaLabel: '搜一下文檔' },
  modal: {
    displayDetails: '展開詳細資料', resetButtonTitle: '清掉啦', backButtonTitle: '回去',
    noResultsText: '找不到東西 QQ',
    footer: {
      selectText: '選這個', selectKeyAriaLabel: 'Enter 啦',
      navigateText: '上下移動', navigateUpKeyAriaLabel: '上箭頭', navigateDownKeyAriaLabel: '下箭頭',
      closeText: '掰掰', closeKeyAriaLabel: 'Esc 嘿',
    },
  },
}

export default defineConfig({
  title: 'YL',
  description: 'Yankee Language - esoteric programming language on PHP with unicode syntax',
  cleanUrls: true,
  sitemap: { hostname: SITE, lastmodDateOnly: true },
  head: [
    ['meta', { name: 'viewport', content: 'width=device-width, initial-scale=1.0, viewport-fit=cover' }],
    ['meta', { name: 'theme-color', content: '#a78bfa', media: '(prefers-color-scheme: light)' }],
    ['meta', { name: 'theme-color', content: '#0f0f17', media: '(prefers-color-scheme: dark)' }],
    ['meta', { name: 'color-scheme', content: 'dark light' }],
    ['link', { rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' }],
    ['link', { rel: 'apple-touch-icon', sizes: '180x180', href: '/apple-touch-icon.png' }],
    ['link', { rel: 'manifest', href: '/manifest.webmanifest' }],
    ['meta', { name: 'apple-mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'apple-mobile-web-app-title', content: 'YL' }],
    ['meta', { name: 'apple-mobile-web-app-status-bar-style', content: 'black-translucent' }],
    ['meta', { name: 'mobile-web-app-capable', content: 'yes' }],
    ['meta', { name: 'application-name', content: 'YL' }],
    ['meta', { name: 'msapplication-TileColor', content: '#a78bfa' }],
    ['meta', { name: 'author', content: 'NormikChel' }],
    ['meta', { name: 'keywords', content: 'YL, Yankee Language, esoteric programming language, PHP, unicode syntax' }],
    ['meta', { name: 'robots', content: 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' }],
    ['link', { rel: 'alternate', hreflang: 'ru', href: SITE + '/' }],
    ['link', { rel: 'alternate', hreflang: 'en', href: SITE + '/en/' }],
    ['link', { rel: 'alternate', hreflang: 'zh-Hans', href: SITE + '/zh-Hans/' }],
    ['link', { rel: 'alternate', hreflang: 'zh-Hant', href: SITE + '/zh-Hant/' }],
    ['link', { rel: 'alternate', hreflang: 'x-default', href: SITE + '/' }],
    ['link', { rel: 'alternate', type: 'application/rss+xml', title: 'YL RSS', href: SITE + '/rss.xml' }],
    ['link', { rel: 'alternate', type: 'application/atom+xml', title: 'YL Atom', href: SITE + '/atom.xml' }],
    ['link', { rel: 'sitemap', type: 'application/xml', href: SITE + '/sitemap.xml' }],
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:site_name', content: 'YL - Yankee Language' }],
    ['meta', { property: 'og:title', content: 'YL - Yankee Language' }],
    ['meta', { property: 'og:description', content: 'Эзотерический язык программирования на PHP с уникальным юникод-синтаксисом.' }],
    ['meta', { property: 'og:url', content: SITE + '/' }],
    ['meta', { property: 'og:image', content: OG_IMG }],
    ['meta', { property: 'og:image:width', content: '1200' }],
    ['meta', { property: 'og:image:height', content: '630' }],
    ['meta', { property: 'og:locale', content: 'ru_RU' }],
    ['meta', { property: 'og:locale:alternate', content: 'en_US' }],
    ['meta', { property: 'og:locale:alternate', content: 'zh_CN' }],
    ['meta', { property: 'og:locale:alternate', content: 'zh_TW' }],
    ['meta', { name: 'twitter:card', content: 'summary_large_image' }],
    ['meta', { name: 'twitter:site', content: '@NormikChel' }],
    ['meta', { name: 'twitter:title', content: 'YL - Yankee Language' }],
    ['meta', { name: 'twitter:description', content: 'Esoteric language on PHP with unicode syntax' }],
    ['meta', { name: 'twitter:image', content: OG_IMG }],
    ['script', { type: 'application/ld+json' }, JSON.stringify({
      '@context': 'https://schema.org',
      '@graph': [
        { '@type': 'WebSite', '@id': SITE + '/#website', url: SITE + '/', name: 'YL - Yankee Language',
          description: 'Esoteric programming language on PHP', inLanguage: ['ru', 'en', 'zh-Hans', 'zh-Hant'],
          publisher: { '@id': SITE + '/#person' },
          potentialAction: { '@type': 'SearchAction',
            target: { '@type': 'EntryPoint', urlTemplate: SITE + '/?q={search_term_string}' },
            'query-input': 'required name=search_term_string' } },
        { '@type': 'Person', '@id': SITE + '/#person', name: 'NormikChel', url: 'https://github.com/NormikChel' },
        { '@type': 'SoftwareApplication', '@id': SITE + '/#app', name: 'YL', alternateName: 'Yankee Language',
          applicationCategory: 'DeveloperApplication', operatingSystem: 'Cross-platform (PHP 8.1+)',
          programmingLanguage: ['PHP', 'Yankee'], license: 'https://opensource.org/licenses/MIT',
          offers: { '@type': 'Offer', price: '0', priceCurrency: 'USD' },
          codeRepository: GH, softwareVersion: '4.0.0' },
      ],
    })],
  ],
  markdown: { languages: [ylGrammar] },

  // === SEARCH В ROOT — чтобы не пропадал ===
  themeConfig: {
    logo: '/logo.svg',
    siteTitle: 'YL',
    socialLinks: [{ icon: 'github', link: GH }],
    search: {
      provider: 'local',
      options: { translations: searchRu },
    },
    outline: { label: 'На этой странице', level: [2, 3] },
    docFooter: { prev: 'Назад', next: 'Вперёд' },
    darkModeSwitchLabel: 'Тема',
    sidebarMenuLabel: 'Меню',
    returnToTopLabel: 'Наверх',
    footer: { message: 'Сделано на PHP. Лицензия MIT.', copyright: '© 2026 YL Contributors' },
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
        search: { provider: 'local', options: { translations: searchRu } },
        editLink: { pattern: GH + '/edit/main/docs/:path', text: 'Редактировать на GitHub' },
        lastUpdated: { text: 'Обновлено' },
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
        sidebar: { '/en/guide/': [{ text: 'Guide', items: [
          { text: 'Getting started', link: '/en/guide/getting-started' },
          { text: 'Syntax', link: '/en/guide/syntax' },
          { text: 'Standard library', link: '/en/guide/stdlib' },
        ]}] },
        search: { provider: 'local', options: { translations: searchEn } },
        outline: { label: 'On this page', level: [2, 3] },
        docFooter: { prev: 'Previous', next: 'Next' },
        darkModeSwitchLabel: 'Appearance',
        sidebarMenuLabel: 'Menu',
        returnToTopLabel: 'Return to top',
        editLink: { pattern: GH + '/edit/main/docs/:path', text: 'Edit this page on GitHub' },
        lastUpdated: { text: 'Updated' },
        footer: { message: 'Built on PHP. MIT License.', copyright: '© 2026 YL Contributors' },
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
        sidebar: { '/zh-Hans/guide/': [{ text: '指南', items: [
          { text: '快速开始', link: '/zh-Hans/guide/getting-started' },
          { text: '语法', link: '/zh-Hans/guide/syntax' },
          { text: '标准库', link: '/zh-Hans/guide/stdlib' },
        ]}] },
        search: { provider: 'local', options: { translations: searchZhHans } },
        outline: { label: '本页目录', level: [2, 3] },
        docFooter: { prev: '上一页', next: '下一页' },
        darkModeSwitchLabel: '外观',
        sidebarMenuLabel: '菜单',
        returnToTopLabel: '返回顶部',
        editLink: { pattern: GH + '/edit/main/docs/:path', text: '在 GitHub 上编辑此页' },
        lastUpdated: { text: '更新于' },
        footer: { message: '基于 PHP 构建。MIT 许可证。', copyright: '© 2026 YL 贡献者' },
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
        sidebar: { '/zh-Hant/guide/': [{ text: '指南', items: [
          { text: '立馬開始', link: '/zh-Hant/guide/getting-started' },
          { text: '語法 der', link: '/zh-Hant/guide/syntax' },
          { text: '標準庫', link: '/zh-Hant/guide/stdlib' },
        ]}] },
        search: { provider: 'local', options: { translations: searchZhHant } },
        outline: { label: '這頁有什麼', level: [2, 3] },
        docFooter: { prev: '回上一頁', next: '下一頁 der' },
        darkModeSwitchLabel: '外觀',
        sidebarMenuLabel: '選單',
        returnToTopLabel: '回到最上面',
        editLink: { pattern: GH + '/edit/main/docs/:path', text: '直接在 GitHub 改這頁啦' },
        lastUpdated: { text: '更新時間' },
        footer: { message: '用 PHP 寫 der。MIT 授權，母湯亂用。', copyright: '© 2026 YL 貢獻者 der' },
      },
    },
  },
})