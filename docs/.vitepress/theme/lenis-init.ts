// YL Smooth scroll via Lenis
// SSR-safe: работает только в браузере.
import Lenis from './lenis.min.js'

let lenis: any = null

function initLenis() {
  if (lenis) return

  // Уважаем предпочтения пользователя (доступность)
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches
  if (prefersReduced) return

  lenis = new (Lenis as any)({
    autoRaf: true,
    lerp: 0.1,
    duration: 1.2,
    wheelMultiplier: 1,
    smoothWheel: true,
    syncTouch: false,
    easing: (x: number) => Math.min(1, 1.001 - Math.pow(2, -10 * x)),
  })

  ;(window as any).lenisInstance = lenis

  // VitePress SPA-навигация: скроллим наверх при переходе
  if (typeof window !== 'undefined') {
    const onRouteChange = () => {
      lenis?.scrollTo(0, { immediate: true })
    }
    // VitePress шлёт свой custom event
    window.addEventListener('vitepress:routeChanged', onRouteChange)
    // fallback на popstate
    window.addEventListener('popstate', onRouteChange)
  }
}

function destroyLenis() {
  if (lenis) {
    lenis.destroy?.()
    lenis = null
  }
}

if (typeof window !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLenis)
  } else {
    initLenis()
  }
  // HMR-очистка (не критично, но чисто)
  if ((import.meta as any).hot) {
    ;(import.meta as any).hot.dispose(destroyLenis)
  }
}

export {}