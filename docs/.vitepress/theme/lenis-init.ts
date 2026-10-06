// YL Lenis — работает даже когда VitePress/Vue стирает className
import './lenis.min.js'

let lenis: any = null

function ensureLenisClasses() {
  if (typeof document === 'undefined') return
  const html = document.documentElement
  html.classList.add('lenis')
  if (lenis?.isScrolling === 'smooth') html.classList.add('lenis-smooth')
  else if (lenis?.isScrolling === 'native') html.classList.add('lenis-smooth')
}

function initLenis() {
  if (lenis) return
  if (typeof window === 'undefined') return

  const LenisCtor = (window as any).Lenis
  if (typeof LenisCtor !== 'function') {
    console.warn('[YL] Lenis ctor not found')
    return
  }

  // Принудительно убираем нативный smooth
  document.documentElement.style.scrollBehavior = 'auto'
  document.body.style.scrollBehavior = 'auto'

  lenis = new LenisCtor({
    autoRaf: true,
    lerp: 0.1,
    duration: 1.2,
    wheelMultiplier: 1,
    touchMultiplier: 1,
    smoothWheel: true,
    syncTouch: false,
    easing: (x: number) => Math.min(1, 1.001 - Math.pow(2, -10 * x)),
  })

  ;(window as any).lenisInstance = lenis

  // Кидаем классы сразу
  ensureLenisClasses()

  // Lenis вызывает updateClassName в своём rAF — ловим и дублируем
  lenis.on('scroll', ensureLenisClasses)

  // MutationObserver: если VitePress стёр className — сразу возвращаем
  const obs = new MutationObserver(() => {
    const html = document.documentElement
    if (!html.classList.contains('lenis')) {
      html.classList.add('lenis')
    }
    if ((lenis?.isScrolling === 'smooth' || lenis?.isScrolling === 'native')
        && !html.classList.contains('lenis-smooth')) {
      html.classList.add('lenis-smooth')
    }
  })
  obs.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class'],
  })

  console.info('[YL Lenis] ready', {
    lerp: 0.1,
    wheelMultiplier: 1,
    classes: document.documentElement.className,
  })
}

if (typeof window !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLenis)
  } else {
    initLenis()
  }
}

export {}