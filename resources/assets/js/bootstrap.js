
import _ from 'lodash';
window._ = _;

/**
 * Optimized Bootstrap and jQuery loading with modern imports
 */

try {
    // Use modern Popper.js
    import('@popperjs/core').then(({ createPopper }) => {
        window.Popper = { createPopper };
    });
    
    // Import jQuery and Bootstrap
    import('jquery').then((jQuery) => {
        window.$ = window.jQuery = jQuery.default;
        
        // Load Bootstrap after jQuery is available
        import('bootstrap').then(() => {
            console.log('Bootstrap loaded successfully');
        });
    });
} catch (e) {
    console.error('Error loading Bootstrap dependencies:', e);
}

/**
 * Optimized Axios configuration with performance improvements
 */

import axios from 'axios';

// Configure axios with optimizations
axios.defaults.timeout = 10000; // 10 second timeout
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add request interceptor for performance monitoring
axios.interceptors.request.use((config) => {
    config.metadata = { startTime: new Date() };
    return config;
});

// Add response interceptor for performance logging
axios.interceptors.response.use(
    (response) => {
        const endTime = new Date();
        const duration = endTime - response.config.metadata.startTime;
        
        if (duration > 2000) { // Log slow requests
            console.warn(`Slow API request: ${response.config.url} took ${duration}ms`);
        }
        
        return response;
    },
    (error) => {
        console.error('API request failed:', error);
        return Promise.reject(error);
    }
);

window.axios = axios;

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
