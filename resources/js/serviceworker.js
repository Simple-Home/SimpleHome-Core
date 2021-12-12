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


var staticCacheName = "pwa-v-" + new Date().getTime();

var filesToCache = [
    //PAGESs
    'controls',
    'automations',
    'offline',
    'system/developments',
    'system/locations',
    //RESOURCES
    'js/manifest.js',
    'js/manifest.js.map',
    'js/vendor.js',
    'js/vendor.js.map',
    'js/app.js',
    'js/app.js.map',
    'js/utillities.js',
    'js/utillities.min.js',

    'js/developments-controller.js',
    'js/locations-controller.js',
    'js/automations.js',
    'js/controls.js',
    'js/locators.js',
    'js/notifications.js',
    'js/push-notifications.js',
    'js/refresh-csrf.js',

    'css/app.css',
    'css/app.css.map',

    'images/icons/icon-72x72.png',
    'images/icons/icon-96x96.png',
    'images/icons/icon-128x128.png',
    'images/icons/icon-144x144.png',
    'images/icons/icon-152x152.png',
    'images/icons/icon-192x192.png',
    'images/icons/icon-384x384.png',
    'images/icons/icon-512x512.png',

    'img/icons/android-chrome-192x192.png',
    'img/icons/android-chrome-512x512.png',
    'img/icons/apple-touch-icon.png',
    'img/icons/favicon-16x16.png',
    'img/icons/favicon-32x32.png',
    'img/icons/favicon-150x150.png',
    'img/icons/safari-pinned-tab.svg',
];


var ignoreRequests = new RegExp('(' + [
    '/ajax'
].join('(\/?)|\\') + ')$')


// Cache on install
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(staticCacheName)
        .then(cache => {
            try {
                return cache.addAll(filesToCache);
            } catch (ex) {
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
    if (ignoreRequests.test(event.request.url)) {
        console.log('[SW]-fetch live:', event.request.url)
        return
    }

    event.respondWith(
        fetch(event.request)
        .then(response => caches.open('offline')
            .then(cache => cache.put(response)))
        .catch(f => caches.open('offline')
            .then(cache => cache
                .match(event.request)
                .then(file => file)
            )
        )
    )


    // event.respondWith(
    //     fetch(event.request)
    //     caches.match(event.request)
    //     .then(response => {
    //         return response || fetch(event.request);
    //     })
    //     .catch(() => {
    //         return caches.match('offline');
    //     })
    // )
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
                } catch (ex) {
                    Log("Caught exception: " + ex);
                }
            })
        )
    } else if (event.data.action === 'refreshCache') {
        caches.keys().then(function (staticCacheName) {
            for (let name of staticCacheName)
                caches.delete(name);
        });
        console.log("Cache - Deleted")
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                .filter(cacheName => (cacheName.startsWith("pwa-v-")))
                .filter(cacheName => (cacheName !== staticCacheName))
                .map(cacheName => caches.delete(cacheName))
            );
        })
        console.log("Cache - Created")

        self.clients.matchAll().then(function (clients) {
            clients.forEach(function (client) {
                client.postMessage({
                    action: "refresh",
                });
            });
        });
    }
});
