// service-worker.js

const CACHE_NAME = "polewatch-cache-v1";
const urlsToCache = [
  "./",
  "./index.html",
  "./style.css",
  "./app.js",
  "./manifest.json"
];

// Install event - cache files
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(urlsToCache);
    })
  );
  console.log("✅ Service Worker: Installed");
});

// Activate event - cleanup old caches
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) =>
      Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            console.log("🗑️ Service Worker: Clearing old cache");
            return caches.delete(cache);
          }
        })
      )
    )
  );
});

// Fetch event - serve cached files if available
self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
