importScripts('https://www.gstatic.com/firebasejs/7.1.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.1.0/firebase-messaging.js');

if (firebase.messaging.isSupported()) {
    if (!firebase.apps.length) {
        firebase.initializeApp({
            messagingSenderId: 'process.env.MIX_FIREBASE_MESSAGING_SENDER_ID',
        });
    } else {
        firebase.app(); // if already initialized, use that one
    }
    const messaging = firebase.messaging();
    // messaging.onMessage((payload) => {
    //     console.log('Message received. ', payload);
    // });
}

var staticCacheName = "pwa-v2-" + new Date().getTime();

var filesToCache = [
    'controls',
    'automations',
    'offline',
    'system/developments',
    'system/locations',
    'css/app.css',
    'js/app.js',
    'js/refresh-csrf.js',
    'js/manifest.js',
    'js/vendor.js',
    'images/icons/icon-72x72.png',
    'images/icons/icon-96x96.png',
    'images/icons/icon-128x128.png',
    'images/icons/icon-144x144.png',
    'images/icons/icon-152x152.png',
    'images/icons/icon-192x192.png',
    'images/icons/icon-384x384.png',
    'images/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                try {
                    return cache.addAll(filesToCache);
                }
                catch (ex) {
                    Log("Caught exception: " + ex);
                }
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-v-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});

// Push Recive
self.addEventListener("push", function (event) {
    if (event.data) {
        var Content = event.data.json().notification;
        var Data = event.data.json().data;
        console.log(Data);
        var Options = {
            body: Content.body,

        };
        if (Content.icon) {
            Options.icon = Content.icon
        }
        if (Content.actions) {
            Options.actions = Content.actions
        }
        event.waitUntil(
            self.registration.showNotification(Content.title, Options)
        );
    }
});

// Message Reciev
self.addEventListener('message', function (event) {
    if (event.data.action === 'skipWaiting') {
        self.skipWaiting();
        event.waitUntil(
            caches.open(staticCacheName)
                .then(cache => {
                    try {
                        console.log("cache clean")
                        return cache.addAll(filesToCache);
                    }
                    catch (ex) {
                        Log("Caught exception: " + ex);
                    }
                })
        )
    }
});
