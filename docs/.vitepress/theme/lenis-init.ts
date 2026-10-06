// YL Smooth scroll via Lenis
// Пресет: очень плавный (lerp 0.04 — мягкая инерция).
// Хочешь резче — увеличивай lerp (0.05 / 0.08 / 0.1).
// Хочешь ещё мягче — уменьшай (0.03 / 0.02 / 0.01).

import Lenis from 'lenis'

let lenis: Lenis | null = null

function initLenis(): void {
  if (lenis) return
  if (typeof window === 'undefined') return

  try {
    lenis = new Lenis({
      autoRaf: true,

      // ── ГЛАВНЫЙ ПАРАМЕТР ПЛАВНОСТИ ──
      // 0.01 — почти как желе (очень долгая инерция)
      // 0.03 — очень плавно
      // 0.04 — плавно  ← сейчас тут
      // 0.06 — умеренно плавно
      // 0.08 — заметно плавно (было)
      // 0.10 — баланс с «нативным»
      // 0.20 — почти как браузер по умолчанию
      lerp: 0.04,

      // ── Множители ──
      // Чувствительность колеса. 1.0 = обычная.
      // Меньше 1 — медленнее, но не плавнее.
      wheelMultiplier: 0.9,
      touchMultiplier: 1.2,

      // ── Что перехватывать ──
      smoothWheel: true,
      syncTouch: false,

      // ── Кривая (применяется в duration-режиме, тут не используется) ──
      easing: (x: number) => Math.min(1, 1.001 - Math.pow(2, -10 * x)),
    })

    ;(window as any).lenisInstance = lenis
    console.info('[YL Lenis] initialized, lerp =', 0.04)
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