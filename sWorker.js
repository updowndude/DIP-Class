// copyright 2017 DipFestival, LLC
/**
 * Created by correywinke on 3/9/17.
 */
// first ran and caches pages
this.addEventListener('install', (event) => {
    // waits until caching pages is done
    event.waitUntil(
        caches.open('v1').then((cache) => {
            // all of the files that get cache
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

// when going to new after install
this.addEventListener('fetch', function(event) {
    // check to see page is in cache alright
    event.respondWith(
        caches.match(event.request).then((resp) => {
            // grap the page
            return resp || fetch(event.request).then((response) => {
                    caches.open('v1').then((cache) => {
                        cache.put(event.request, response.clone());
                    });
                    return response;
                });
         // if there error return the offline version of the site
        }).catch(() => {
            return caches.match('/DIP-Class/dist/offline.html');
        })
    );
});