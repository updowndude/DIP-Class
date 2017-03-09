/**
 * Created by correywinke on 3/9/17.
 */
this.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('v1').then((cache) => {
            return cache.addAll([
                '/DIP-Class/',
                '/DIP-Class/dist/myStyle.css',
                '/DIP-Class/dist/my-com.js',
                '/DIP-Class/dist/offline.html',
                '/DIP-Class/images/favicon.ico'
            ]);
        })
    );
});

this.addEventListener('fetch', (event) => {
    console.log(event.request.url);

    let response;
    event.respondWith(caches.match(event.request).catch(() => {
        return fetch(event.request);
    }).then((r)  => {
        response = r;
        caches.open('v1').then((cache) => {
            cache.put(event.request, response);
        });
        return response.clone();
    }).catch(() => {
        return caches.match('/DIP-Class/dist/offline.html');
    }));
});