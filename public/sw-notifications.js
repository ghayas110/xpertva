/* ===========================================================================
   XpertVA portal service worker.

   Three jobs, in order of importance:

   1. `push`  — receives background notifications from the push service and
      shows them. This is what makes alerts arrive with the portal closed.
   2. `notificationclick` — opens the page the notification points at,
      reusing an already open portal window where there is one.
   3. `fetch`  — a navigation-only handler. Chrome will not offer "Install app"
      without one, and it gives an offline page instead of the browser's error.

   It deliberately caches no portal pages: they are per user and carry live
   data, and a cached dashboard could show one operator another's screen.
   =========================================================================== */

const XV_SHELL   = 'xv-shell-v1';
const XV_OFFLINE = '/offline.html';

const XV_ICON  = '/android-chrome-192x192.png';
const XV_BADGE = '/favicon-32x32.png';

/* --------------------------------------------------------------------------
   Lifecycle
   -------------------------------------------------------------------------- */

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(XV_SHELL)
            .then((cache) => cache.addAll([XV_OFFLINE]))
            .catch(() => {})            // offline page missing must not block install
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(
                keys.filter((k) => k.startsWith('xv-shell-') && k !== XV_SHELL)
                    .map((k) => caches.delete(k))
            ))
            .catch(() => {})
            .then(() => self.clients.claim())
    );
});

/* --------------------------------------------------------------------------
   Background notifications
   -------------------------------------------------------------------------- */

self.addEventListener('push', (event) => {
    // iOS is strict about this: a push event that resolves without showing a
    // notification can get the subscription revoked. So every path below ends
    // in showNotification, even one carrying no readable payload.
    let data = {};
    if (event.data) {
        try {
            data = event.data.json() || {};
        } catch (e) {
            try {
                data = { body: event.data.text() };
            } catch (e2) {
                data = {};
            }
        }
    }

    const title = data.title || 'XpertVA';
    const url   = data.url || '/dashboard';

    const options = {
        body:  data.body || '',
        icon:  data.icon  || XV_ICON,
        badge: data.badge || XV_BADGE,

        // Shared with the in-page notifier. A notification that arrives both
        // ways replaces itself in the tray instead of appearing twice, and
        // renotify stays off so the replacement does not buzz a second time.
        tag: data.tag || 'xpertva-push',
        renotify: false,

        data: { url: url },
        timestamp: Date.now()
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
            .then(() => bumpAppBadge())
            .catch(() => {})
    );
});

/* Keep the home screen icon's dot in step with the unread count, where the
   platform supports it. Android Chrome does; iOS currently ignores it. */
function bumpAppBadge() {
    if (!self.navigator || !self.navigator.setAppBadge) return Promise.resolve();
    return self.registration.getNotifications()
        .then((list) => self.navigator.setAppBadge(list.length || 1))
        .catch(() => {});
}

/* --------------------------------------------------------------------------
   Clicking a notification
   -------------------------------------------------------------------------- */

self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    const target = (event.notification.data && event.notification.data.url) || '/dashboard';

    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientsArr) => {
            // Reuse an open portal window rather than stacking up new ones.
            for (const client of clientsArr) {
                if (!('focus' in client)) continue;
                // navigate() rejects for a client this worker does not control,
                // and it rejects asynchronously, so it needs a .catch() rather
                // than a try/catch. Falling back to focus still gets the
                // operator into the portal.
                if ('navigate' in client) {
                    return client.navigate(target)
                        .then((c) => (c || client).focus())
                        .catch(() => client.focus());
                }
                return client.focus();
            }

            if (self.clients.openWindow) return self.clients.openWindow(target);
        }).catch(() => {
            if (self.clients.openWindow) return self.clients.openWindow(target);
        })
    );
});

/* --------------------------------------------------------------------------
   Subscription rotation

   Browsers occasionally replace a push subscription on their own. Chrome hands
   us the replacement here; everything else is repaired on the next page load,
   because the portal re-checks its subscription every time it boots.
   -------------------------------------------------------------------------- */

self.addEventListener('pushsubscriptionchange', (event) => {
    // The worker cannot re-register the subscription itself: /push/subscribe is
    // CSRF protected and no token is reachable from here. That protection is
    // load bearing — without it another site could quietly point this user's
    // notifications at a subscription of its own.
    //
    // So ask an open portal page to do it, and if none is open leave it: the
    // portal re-checks its subscription on every boot, so the next visit
    // repairs it anyway.
    event.waitUntil(
        self.clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then((clientsArr) => {
                clientsArr.forEach((client) => client.postMessage({ type: 'xv-resubscribe' }));
            })
            .catch(() => {})
    );
});

/* --------------------------------------------------------------------------
   Navigation fallback (also what makes the portal installable)
   -------------------------------------------------------------------------- */

self.addEventListener('fetch', (event) => {
    const req = event.request;

    // Only page navigations, and only plain GETs.
    if (req.method !== 'GET' || req.mode !== 'navigate') return;

    event.respondWith(
        fetch(req).catch(() => caches.match(XV_OFFLINE).then(
            (cached) => cached || new Response('Offline', {
                status: 503,
                headers: { 'Content-Type': 'text/plain' }
            })
        ))
    );
});
