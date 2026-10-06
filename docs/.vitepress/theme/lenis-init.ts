// YL Smooth scroll via Lenis (npm package)
// SSR-safe — работает только в браузере.

import Lenis from 'lenis'

let lenis: Lenis | null = null

function initLenis(): void {
  if (lenis) return
  if (typeof window === 'undefined') return

  // Уважаем настройки доступности
  if (window.matchMedia?.('(prefers-reduced-motion: reduce)').matches) return

  lenis = new Lenis({
    autoRaf: true,
    lerp: 0.1,
    duration: 1.2,
    wheelMultiplier: 1,
    smoothWheel: true,
    syncTouch: false,
    easing: (x: number) => Math.min(1, 1.001 - Math.pow(2, -10 * x)),
  })

  ;(window as any).lenisInstance = lenis

  // VitePress SPA: сброс скролла наверх при переходе по страницам
  const onRouteChange = () => lenis?.scrollTo(0, { immediate: true })
  window.addEventListener('vitepress:routeChanged', onRouteChange)
  window.addEventListener('popstate', onRouteChange)
}

function destroyLenis(): void {
  lenis?.destroy()
  lenis = null
}

if (typeof window !== 'undefined') {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLenis)
  } else {
    initLenis()
  }
}

export {}