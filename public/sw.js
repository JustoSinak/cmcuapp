const CACHE_NAME = 'cmcu-hms-v1.0.0';
const OFFLINE_URL = '/offline.html';

// Assets to cache for offline functionality
const STATIC_CACHE_URLS = [
  '/',
  '/admin/dashboard',
  '/offline.html',
  '/css/app.css',
  '/js/app.js',
  '/images/logo.png',
  '/images/icons/icon-192x192.png',
  '/images/icons/icon-512x512.png',
  // Add more critical assets
];

// API endpoints to cache
const API_CACHE_URLS = [
  '/api/dashboard/stats',
  '/api/patients/recent',
  '/api/patients/statistics',
];

// Install event - cache static assets
self.addEventListener('install', (event) => {
  console.log('Service Worker: Installing...');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => {
        console.log('Service Worker: Caching static assets');
        return cache.addAll(STATIC_CACHE_URLS);
      })
      .then(() => {
        console.log('Service Worker: Installation complete');
        return self.skipWaiting();
      })
      .catch((error) => {
        console.error('Service Worker: Installation failed', error);
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
  console.log('Service Worker: Activating...');
  
  event.waitUntil(
    caches.keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheName !== CACHE_NAME) {
              console.log('Service Worker: Deleting old cache', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => {
        console.log('Service Worker: Activation complete');
        return self.clients.claim();
      })
  );
});

// Fetch event - serve cached content when offline
self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Handle navigation requests
  if (request.mode === 'navigate') {
    event.respondWith(
      fetch(request)
        .then((response) => {
          // Cache successful navigation responses
          if (response.status === 200) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(request, responseClone);
              });
          }
          return response;
        })
        .catch(() => {
          // Serve cached page or offline page
          return caches.match(request)
            .then((cachedResponse) => {
              if (cachedResponse) {
                return cachedResponse;
              }
              return caches.match(OFFLINE_URL);
            });
        })
    );
    return;
  }

  // Handle API requests with network-first strategy
  if (url.pathname.startsWith('/api/')) {
    event.respondWith(
      fetch(request)
        .then((response) => {
          // Cache successful API responses
          if (response.status === 200 && request.method === 'GET') {
            const responseClone = response.clone();
            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(request, responseClone);
              });
          }
          return response;
        })
        .catch(() => {
          // Serve cached API response if available
          return caches.match(request)
            .then((cachedResponse) => {
              if (cachedResponse) {
                // Add offline indicator to cached response
                return cachedResponse.json()
                  .then((data) => {
                    data._offline = true;
                    data._cached_at = new Date().toISOString();
                    return new Response(JSON.stringify(data), {
                      headers: { 'Content-Type': 'application/json' }
                    });
                  });
              }
              
              // Return offline response for critical endpoints
              if (isCriticalEndpoint(url.pathname)) {
                return new Response(JSON.stringify({
                  success: false,
                  message: 'Offline - cached data not available',
                  _offline: true
                }), {
                  headers: { 'Content-Type': 'application/json' }
                });
              }
              
              throw new Error('No cached response available');
            });
        })
    );
    return;
  }

  // Handle static assets with cache-first strategy
  if (isStaticAsset(request.url)) {
    event.respondWith(
      caches.match(request)
        .then((cachedResponse) => {
          if (cachedResponse) {
            return cachedResponse;
          }
          
          return fetch(request)
            .then((response) => {
              if (response.status === 200) {
                const responseClone = response.clone();
                caches.open(CACHE_NAME)
                  .then((cache) => {
                    cache.put(request, responseClone);
                  });
              }
              return response;
            });
        })
    );
    return;
  }

  // Default: network-first for everything else
  event.respondWith(
    fetch(request)
      .catch(() => {
        return caches.match(request);
      })
  );
});

// Background sync for offline actions
self.addEventListener('sync', (event) => {
  console.log('Service Worker: Background sync triggered', event.tag);
  
  if (event.tag === 'patient-data-sync') {
    event.waitUntil(syncPatientData());
  }
  
  if (event.tag === 'consultation-sync') {
    event.waitUntil(syncConsultationData());
  }
});

// Push notifications
self.addEventListener('push', (event) => {
  console.log('Service Worker: Push notification received');
  
  const options = {
    body: 'You have new updates in CMCU HMS',
    icon: '/images/icons/icon-192x192.png',
    badge: '/images/icons/badge-72x72.png',
    vibrate: [200, 100, 200],
    data: {
      url: '/admin/dashboard'
    },
    actions: [
      {
        action: 'view',
        title: 'View Dashboard',
        icon: '/images/icons/view-action.png'
      },
      {
        action: 'dismiss',
        title: 'Dismiss',
        icon: '/images/icons/dismiss-action.png'
      }
    ]
  };

  if (event.data) {
    const payload = event.data.json();
    options.body = payload.message || options.body;
    options.data.url = payload.url || options.data.url;
  }

  event.waitUntil(
    self.registration.showNotification('CMCU HMS', options)
  );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
  console.log('Service Worker: Notification clicked');
  
  event.notification.close();
  
  if (event.action === 'view') {
    event.waitUntil(
      clients.openWindow(event.notification.data.url)
    );
  }
});

// Helper functions
function isStaticAsset(url) {
  const staticExtensions = ['.css', '.js', '.png', '.jpg', '.jpeg', '.gif', '.svg', '.woff', '.woff2'];
  return staticExtensions.some(ext => url.includes(ext));
}

function isCriticalEndpoint(pathname) {
  const criticalEndpoints = [
    '/api/dashboard/stats',
    '/api/patients/recent',
    '/api/patients/statistics'
  ];
  return criticalEndpoints.includes(pathname);
}

async function syncPatientData() {
  try {
    console.log('Service Worker: Syncing patient data...');
    
    // Get offline patient data from IndexedDB
    const offlineData = await getOfflinePatientData();
    
    if (offlineData.length > 0) {
      // Send offline data to server
      const response = await fetch('/api/patients/sync', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${await getAuthToken()}`
        },
        body: JSON.stringify({ patients: offlineData })
      });
      
      if (response.ok) {
        // Clear synced data from IndexedDB
        await clearSyncedPatientData();
        console.log('Service Worker: Patient data synced successfully');
      }
    }
  } catch (error) {
    console.error('Service Worker: Patient data sync failed', error);
  }
}

async function syncConsultationData() {
  try {
    console.log('Service Worker: Syncing consultation data...');
    
    // Similar implementation for consultation data
    const offlineData = await getOfflineConsultationData();
    
    if (offlineData.length > 0) {
      const response = await fetch('/api/consultations/sync', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${await getAuthToken()}`
        },
        body: JSON.stringify({ consultations: offlineData })
      });
      
      if (response.ok) {
        await clearSyncedConsultationData();
        console.log('Service Worker: Consultation data synced successfully');
      }
    }
  } catch (error) {
    console.error('Service Worker: Consultation data sync failed', error);
  }
}

// IndexedDB helper functions (simplified)
async function getOfflinePatientData() {
  // Implementation would use IndexedDB to retrieve offline patient data
  return [];
}

async function clearSyncedPatientData() {
  // Implementation would clear synced data from IndexedDB
}

async function getOfflineConsultationData() {
  // Implementation would use IndexedDB to retrieve offline consultation data
  return [];
}

async function clearSyncedConsultationData() {
  // Implementation would clear synced data from IndexedDB
}

async function getAuthToken() {
  // Implementation would retrieve auth token from storage
  return '';
}

// Version update notification
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});
