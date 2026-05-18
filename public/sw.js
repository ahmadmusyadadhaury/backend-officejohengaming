// Service Worker — Johen Gaming Meeting Room
// Handles Web Push Notifications di background

self.addEventListener('push', function(event) {
    if (!event.data) return;

    const data = event.data.json();

    const options = {
        body:    data.body  || 'Ada notifikasi baru',
        icon:    data.icon  || '/images/logo/logo_web.png',
        badge:   '/images/logo/logo_web.png',
        vibrate: [300, 150, 300, 150, 300],
        data:    { url: data.url || '/',
                  tag: data.tag || 'default' },
        actions: [
            { action: 'open',    title: 'Buka' },
            { action: 'dismiss', title: 'Tutup' },
        ],
        requireInteraction: true,
        silent: false,
    };

    event.waitUntil(
        self.registration.showNotification(data.title || 'Johen Gaming Meeting Room', options)
    );
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    if (event.action === 'dismiss') return;

    const url = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            // Jika tab sudah terbuka, fokus ke sana
            for (const client of clientList) {
                if (client.url.includes(self.location.origin) && 'focus' in client) {
                    client.navigate(url);
                    return client.focus();
                }
            }
            // Jika tidak ada tab, buka baru
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
});

self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(clients.claim());
});
