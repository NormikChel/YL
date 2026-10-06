// YL locale preference + auto-redirect
// Запоминает выбранный язык в localStorage и редиректит root → сохранённый язык.

const STORAGE_KEY = 'yl-locale'
const SESSION_FLAG = 'yl-locale-checked'
const LOCALES = ['ar','de','en','fr','hi','id','ja','ko','tr','vi','zh-Hans','zh-Hant']

function detectLocale(path) {
  for (const loc of LOCALES) {
    if (path === '/' + loc || path.startsWith('/' + loc + '/')) return loc
  }
  return null // root (ru)
}

function buildRedirectPath(targetLocale, currentPath) {
  // currentPath типа '/', '/guide/syntax', '/en/guide/syntax'
  // Мы уже на root, значит: склеиваем '/{loc}' + currentPath (если currentPath = '/', то просто '/{loc}/')
  const tail = currentPath === '/' ? '/' : currentPath
  return '/' + targetLocale + tail
}

if (typeof window !== 'undefined') {
  const path = window.location.pathname
  const current = detectLocale(path)

  if (current !== null) {
    // На языке — запоминаем
    try { localStorage.setItem(STORAGE_KEY, current) } catch {}
  } else {
    // На root — проверяем сохранённый
    let redirected = false
    try { redirected = sessionStorage.getItem(SESSION_FLAG) === '1' } catch {}
    if (!redirected) {
      let saved = null
      try { saved = localStorage.getItem(STORAGE_KEY) } catch {}
      if (saved && LOCALES.includes(saved)) {
        try { sessionStorage.setItem(SESSION_FLAG, '1') } catch {}
        const newPath = buildRedirectPath(saved, path)
        window.location.replace(newPath + window.location.search + window.location.hash)
      }
    }
  }
}

// После перехода по клику — обновляем localStorage
document.addEventListener('DOMContentLoaded', () => {
  const save = () => {
    const loc = detectLocale(window.location.pathname)
    if (loc !== null) {
      try { localStorage.setItem(STORAGE_KEY, loc) } catch {}
    }
  }
  // VitePress не шлёт popstate при SPA-навигации, но у него есть свой роутер
  // Проще всего — слушать click на ссылках локали
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a')
    if (!a) return
    const href = a.getAttribute('href') || ''
    // locale picker формирует ссылки /xx/ и /
    setTimeout(save, 100)
  }, true)
})