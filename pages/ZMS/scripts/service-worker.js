const CACHE_NAME = 'v1'; // Cache version
const CACHE_ASSETS = [
    "../../icons/css/all.css",
    "../css/dash.css",
    "../css/membership.css",
    "../css/dashstyle.css",
    "../css/slick.css",
    "../css/slick-theme.css",
    "apexcharts-bundle/dist/apexcharts.js",
    "Access.js",
    "Assets.js",
    "apexcharts-bundle/dist/apexcharts.js",
    "apexcharts-bundle/samples/assets/stock-prices.js",
    "finance.js",
    "calender.js",
    "xlsx.full.min.js",
    "slick.min.js",
    "slick-animation.min.js",
    "jquery.js"
];

// Install Event
self.addEventListener('install', (event) => {
    console.log('Service Worker: Installed');

    // Cache assets
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('Service Worker: Caching Files');
                return cache.addAll(CACHE_ASSETS);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate Event
self.addEventListener('activate', (event) => {
    console.log('Service Worker: Activated');
    // Remove old caches
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log('Service Worker: Clearing Old Cache');
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Fetch Event (to serve cached content)
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.match(event.request).then((cachedResponse) => {
                const fetchPromise = fetch(event.request).then((networkResponse) => {
                    cache.put(event.request, networkResponse.clone());
                    return networkResponse;
                });
                return cachedResponse || fetchPromise;
            });
        })
    );
});