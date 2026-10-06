<template>
  <a
    ref="btnEl"
    href="#"
    class="bvi-open"
    aria-label="Версия для слабовидящих"
    title="Версия для слабовидящих"
    @click.prevent="onClick"
  >
    <span aria-hidden="true" class="bvi-open-icon">👁</span>
  </a>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const btnEl = ref(null)
let bvi = null

function tryInitBvi() {
  if (typeof window === 'undefined') return
  if (typeof window.Bvi !== 'function') return
  if (bvi) return
  try {
    bvi = new window.Bvi()
  } catch (e) {
    console.warn('[YL BVI] init warning:', e)
  }
}

function onClick(e) {
  // BVI сам подписывается на клик, но для надёжности
  // на случай race condition — вызываем панель вручную
  if (bvi && typeof bvi.show === 'function') {
    bvi.show()
    return
  }
  // fallback: клик по ссылке с классом .bvi-open сам обрабатывается
  // если BVI успел подписаться
}

let t = null
onMounted(() => {
  if (typeof window === 'undefined') return
  // Ждём пока bvi.min.js загрузится (он в head, но на медленной сети может быть позже)
  let n = 0
  const tick = () => {
    if (typeof window.Bvi === 'function') { tryInitBvi(); return }
    if (++n < 100) t = setTimeout(tick, 100)
    else console.warn('[YL BVI] Bvi not found after 10s')
  }
  tick()
})

onBeforeUnmount(() => {
  if (t) clearTimeout(t)
  // bvi destroy если поддерживается
  if (bvi && typeof bvi.destroy === 'function') {
    try { bvi.destroy() } catch (_) {}
  }
  bvi = null
})
</script>

<style scoped>
.bvi-open {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  margin-right: 8px;
  border-radius: 8px;
  text-decoration: none;
  cursor: pointer;
  transition: background-color .2s;
  color: var(--vp-c-text-1);
}
.bvi-open:hover {
  background-color: var(--vp-c-bg-soft);
}
.bvi-open-icon {
  font-size: 18px;
  line-height: 1;
}
</style>