// YL Smooth scroll via Lenis (npm package)
// SSR-safe.
//
// ВАЖНО: prefers-reduced-motion игнорируется — плавный скролл
// является частью дизайна сайта. Если понадобится доступность —
// вернуть проверку.

import Lenis from 'lenis'

let lenis: Lenis | null = null

function initLenis(): void {
  if (lenis) return
  if (typeof window === 'undefined') return

  try {
    lenis = new Lenis({
      autoRaf: true,
      lerp: 0.08,
      duration: 1.2,
      wheelMultiplier: 1,
      touchMultiplier: 1.5,
      smoothWheel: true,
      syncTouch: false,
      easing: (x: number) => Math.min(1, 1.001 - Math.pow(2, -10 * x)),
    })

    ;(window as any).lenisInstance = lenis
    console.info('[YL Lenis] initialized')
  } catch (e) {
    console.error('[YL Lenis] init failed', e)
    return
  }

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