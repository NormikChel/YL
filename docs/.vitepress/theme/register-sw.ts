// YL Service Worker register
if (typeof window !== 'undefined' && 'serviceWorker' in navigator && location.protocol === 'https:') {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js', { scope: '/' })
      .then((reg) => console.info('[YL] SW registered', reg.scope))
      .catch((err) => console.warn('[YL] SW failed', err));
  });
}
