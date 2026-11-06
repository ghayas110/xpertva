// XpertVA notification service worker
// Lets the page show OS notifications via registration.showNotification(),
// which is more reliable across browsers/OSes than `new Notification()`
// and surfaces the toast even when the tab is in the background.

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = event.notification.data && event.notification.data.url;
    if (!url) return;
    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientsArr) => {
            for (const c of clientsArr) {
                if ('focus' in c) {
                    c.navigate(url);
                    return c.focus();
                }
            }
            if (self.clients.openWindow) return self.clients.openWindow(url);
        })
    );
});

/* ---------------------------------------------------------------------------
   Installable portal (PWA).

   Chrome will only offer "Install app" when the service worker has a fetch
   handler, so this adds one. It deliberately does NOT cache portal pages:
   they are per user and carry live data, and a cached dashboard would show one
   operator another operator's screen. Navigations go to the network, and only
   if the network is unreachable do we fall back to a small offline page.
   Everything that is not a navigation is left completely untouched.
--------------------------------------------------------------------------- */
const XV_SHELL = 'xv-shell-v1';
const XV_OFFLINE = '/offline.html';

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(XV_SHELL).then((cache) => cache.addAll([XV_OFFLINE])).catch(() => {})
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => Promise.all(
            keys.filter((k) => k.startsWith('xv-shell-') && k !== XV_SHELL)
                .map((k) => caches.delete(k))
        )).catch(() => {})
    );
});

self.addEventListener('fetch', (event) => {
    const req = event.request;

    // Only page navigations, and only plain GETs.
    if (req.method !== 'GET' || req.mode !== 'navigate') return;

    event.respondWith(
        fetch(req).catch(() => caches.match(XV_OFFLINE).then(
            (cached) => cached || new Response('Offline', { status: 503, headers: { 'Content-Type': 'text/plain' } })
        ))
    );
});
