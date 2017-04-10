var CACHE_NAME = 'is-cache-v1';
var urlsToCache = [
  'en/',
  'de/',
  'it/',
  'style/colors.css',
  'style/desktop_mq.css',
  'style/high_res.css',
  'style/main.css',
  'js/content.js',
  'js/init.js',
  'js/notifications.js',
  'js/sandwitch.js',
  'API/html.php?action=getCompanies'
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});

self.addEventListener('notificationclick', event => {  
  clients.openWindow("/?site=company&id="+event.notification.data);
  event.notification.close();  
});
