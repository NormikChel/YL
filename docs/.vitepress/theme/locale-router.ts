// YL locale preference + auto-redirect.
// ВАЖНО: вся логика внутри onMounted — иначе SSR при build падает на "document is not defined".

const STORAGE_KEY = 'yl-locale'
const SESSION_FLAG = 'yl-locale-checked'
const LOCALES = ['ar','de','en','fr','hi','id','ja','ko','tr','vi','zh-Hans','zh-Hant']

function detectLocale(path: string): string | null {
  for (const loc of LOCALES) {
    if (path === '/' + loc || path.startsWith('/' + loc + '/')) return loc
  }
  return null
}

function redirectToSavedLocale(): void {
  const path = window.location.pathname
  const current = detectLocale(path)

  if (current !== null) {
    try { localStorage.setItem(STORAGE_KEY, current) } catch {}
    return
  }

  // На root — проверяем сохранённый язык
  let redirected = false
  try { redirected = sessionStorage.getItem(SESSION_FLAG) === '1' } catch {}
  if (redirected) return

  let saved: string | null = null
  try { saved = localStorage.getItem(STORAGE_KEY) } catch {}
  if (!saved || !LOCALES.includes(saved)) return

  try { sessionStorage.setItem(SESSION_FLAG, '1') } catch {}

  const tail = path === '/' ? '/' : path
  const newPath = '/' + saved + tail + window.location.search + window.location.hash
  window.location.replace(newPath)
}

// Только в браузере!
if (typeof window !== 'undefined') {
  // Редирект сразу, до гидрации
  redirectToSavedLocale()

  // Сохраняем язык при клике по ссылкам
  if (typeof document !== 'undefined') {
    document.addEventListener('click', () => {
      setTimeout(() => {
        const loc = detectLocale(window.location.pathname)
        if (loc !== null) {
          try { localStorage.setItem(STORAGE_KEY, loc) } catch {}
        }
      }, 100)
    }, true)
  }
}

export {}