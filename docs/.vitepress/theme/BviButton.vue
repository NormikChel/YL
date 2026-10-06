<template>
  <a
    href="#"
    class="bvi-open"
    aria-label="Версия для слабовидящих"
    title="Версия для слабовидящих"
  >Версия для слабовидящих</a>
</template>

<script setup>
// Никакой логики — BVI сам подписывается на .bvi-open через target
</script>

<style scoped>
.bvi-open {
  display: inline-flex;
  align-items: center;
  margin-right: 12px;
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 13px;
  text-decoration: none;
  color: var(--vp-c-text-2);
  border: 1px solid var(--vp-c-divider);
  transition: all .2s;
  white-space: nowrap;
}
.bvi-open:hover {
  color: var(--vp-c-brand-1);
  border-color: var(--vp-c-brand-1);
  background: var(--vp-c-bg-soft);
}
@media (max-width: 768px) {
  .bvi-open {
    font-size: 0;
    padding: 4px 8px;
  }
  .bvi-open::before {
    content: '👁';
    font-size: 16px;
  }
}
</style>