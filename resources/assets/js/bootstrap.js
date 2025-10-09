import _ from 'lodash';
window._ = _;

/**
 * Bootstrap 5 and modern dependencies loading
 */

try {
    // Import Popper.js for Bootstrap 5
    import('@popperjs/core').then(({ createPopper, detectOverflow, popperGenerator }) => {
        window.Popper = { createPopper, detectOverflow, popperGenerator };
    });
    
    // Import jQuery (still needed for legacy code)
    import('jquery').then((jQuery) => {
        window.$ = window.jQuery = jQuery.default;
        
        // Load Bootstrap 5 after jQuery is available
        import('bootstrap').then((bootstrap) => {
            // Make Bootstrap available globally for legacy code
            window.bootstrap = bootstrap;
            console.log('Bootstrap 5 loaded successfully');
            
            // Initialize Bootstrap tooltips and popovers globally
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });
    });
} catch (e) {
    console.error('Error loading Bootstrap 5 dependencies:', e);
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
 * CSRF Token configuration for Laravel
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo configuration (commented out - uncomment if needed)
 */

// import Echo from 'laravel-echo'
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
