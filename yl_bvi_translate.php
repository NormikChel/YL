<?php
declare(strict_types=1);
$THEME = __DIR__ . '/docs/.vitepress/theme';

$vue = <<<'VUE'
<template>
  <a
    href="#"
    class="bvi-open"
    :aria-label="label"
    :title="label"
  >
    <svg
      class="bvi-icon"
      width="18" height="18"
      viewBox="0 0 24 24"
      fill="none" stroke="currentColor"
      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
      aria-hidden="true"
    >
      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
      <circle cx="12" cy="12" r="3"/>
    </svg>
    <span class="bvi-label">{{ label }}</span>
  </a>
</template>

<script setup>
import { computed } from 'vue'
import { useData } from 'vitepress'

const { lang } = useData()

const translations = {
  'ru':     'Версия для слабовидящих',
  'en':     'Visually impaired version',
  'de':     'Version für Sehbehinderte',
  'fr':     'Version malvoyante',
  'hi':     'दृष्टिबाधित संस्करण',
  'id':     'Versi tunanetra',
  'ja':     '視覚障害者向け',
  'ko':     '시각 장애인용',
  'tr':     'Görme engelliler için',
  'vi':     'Phiên bản khiếm thị',
  'ar':     'نسخة ضعاف البصر',
  'zh-Hans': '无障碍版本',
  'zh-Hant': '無障礙版本',
}

const label = computed(() => translations[lang.value] || translations['en'])
</script>

<style scoped>
.bvi-open {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  height: 36px;
  padding: 0 12px;
  margin-right: 4px;
  border-radius: 8px;
  border: none;
  background: transparent;
  text-decoration: none;
  color: var(--vp-c-text-1);
  font-size: 13px;
  font-weight: 500;
  line-height: 1;
  white-space: nowrap;
  cursor: pointer;
  transition: background-color .2s ease, color .2s ease;
}
.bvi-open:hover {
  background-color: var(--vp-c-bg-soft);
  color: var(--vp-c-brand-1);
}
.bvi-open:focus-visible {
  outline: 2px solid var(--vp-c-brand-1);
  outline-offset: 2px;
}
.bvi-icon {
  flex-shrink: 0;
}

/* Узкие экраны — только иконка */
@media (max-width: 1100px) {
  .bvi-label { display: none; }
  .bvi-open { padding: 0 8px; width: 36px; justify-content: center; }
}
</style>
VUE;

file_put_contents($THEME . '/BviButton.vue', $vue);
echo "✓ BviButton.vue обновлён:\n";
echo "  • Иконка глаза (SVG, как в остальных кнопках навбара)\n";
echo "  • 13 переводов через useData().lang\n";
echo "  • Адаптив: на узких экранах только иконка\n";
echo "  • Плавный hover, focus-ring для доступности\n";
echo "\nДальше:\n";
echo "  Ctrl+C → npm run docs:dev → Ctrl+Shift+R\n";