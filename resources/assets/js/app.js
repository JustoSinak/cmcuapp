/**
 * Modern Vue 3 application entry point with Bootstrap 5 and FontAwesome 6
 */

// Import core dependencies
import './bootstrap';
import { createApp } from 'vue';

// Create Vue 3 application
const app = createApp({
    template: '<div></div>', // Empty template to prevent warning
    async mounted() {
        // Configure Vue 3 compatibility mode for gradual migration
        try {
            const { configureCompat } = await import('@vue/compat');
            configureCompat({
                MODE: 2, // Vue 2 compatibility mode
                GLOBAL_MOUNT: false,
                GLOBAL_EXTEND: false,
                GLOBAL_PROTOTYPE: false,
                GLOBAL_SET: false,
                GLOBAL_DELETE: false,
                GLOBAL_OBSERVABLE: false,
                CONFIG_OPTION_MERGE_STRATS: false,
                CONFIG_WHITESPACE: false,
            });
        } catch (e) {
            console.warn('Vue compat mode not available:', e);
        }

        // Load admin scripts if needed
        if (document.querySelector('.admin-panel')) {
            try {
                const { default: adminModule } = await import('./admin/main.js');
            } catch (e) {
                console.warn('Admin module not found:', e);
            }
        }
        
        // Initialize search if search elements exist
        if (document.querySelector('.search-container')) {
            try {
                const InstantSearch = await import('vue-instantsearch');
                app.use(InstantSearch.default);
            } catch (e) {
                console.warn('InstantSearch not available:', e);
            }
        }
    }
});

// Register components asynchronously for better performance
app.component('example-component', () => import('./components/ExampleComponent.vue'));

// Mount the application only if #app element exists
const appElement = document.querySelector('#app');
if (appElement) {
    app.mount('#app');
} else {
    console.warn('Vue mount target #app not found. Vue app not mounted.');
}
