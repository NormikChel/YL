// YL Smooth scroll via Lenis — очень плавный пресет.

import Lenis from 'lenis'

let lenis: Lenis | null = null

function initLenis(): void {
  if (lenis) return
  if (typeof window === 'undefined') return

  try {
    lenis = new Lenis({
      autoRaf: true,

      // ── Очень плавно ──
      lerp: 0.02,           // было 0.04 → 0.02 (вдвое мягче)

      // ── Меньше движения за один тик колеса ──
      wheelMultiplier: 0.6, // было 0.9 → 0.6 (медленнее и мягче)
      touchMultiplier: 1.0,

      smoothWheel: true,
      syncTouch: false,
      infinite: false,

      // ── Явно отключаем нативный smooth у html/body ──
      prevent: (node: HTMLElement) => node.hasAttribute?.('data-lenis-prevent'),
    })

    ;(window as any).lenisInstance = lenis

    // Ключевой момент: убеждаемся, что html не имеет scroll-behavior: smooth
    document.documentElement.style.scrollBehavior = 'auto'
    document.body.style.scrollBehavior = 'auto'

    console.info('[YL Lenis] initialized', {
      lerp: lenis.options?.lerp,
      wheelMultiplier: lenis.options?.wheelMultiplier,
    })

    // Диагностика — покажет, что Lenis реально ловит wheel
    window.addEventListener('wheel', () => {
      // если тут что-то — Lenis ловит события
    }, { passive: true })
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