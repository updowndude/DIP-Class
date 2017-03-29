/**
 * Created by correywinke on 3/9/17.
 */
this.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('v1').then((cache) => {
            return cache.addAll([
                '/maingate/',
                '/maingate/dist/myStyle.css',
                '/maingate/dist/my-com.js',
                '/maingate/dist/offline.html',
                '/maingate/images/favicon.ico'
            ]);
        })
    );
});

this.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then((resp) => {
            return resp || fetch(event.request).then((response) => {
                    caches.open('v1').then((cache) => {
                        cache.put(event.request, response.clone());
                    });
                    return response;
                });
        }).catch(() => {
            return caches.match('/maingate/dist/offline.html');
        })
    );
});