
/**
 * Optimized application entry point with performance improvements
 */

// Import core dependencies
import './bootstrap';
import Vue from 'vue';

// Lazy load InstantSearch only when needed
const loadInstantSearch = () => import('vue-instantsearch');

// Global Vue configuration for performance
Vue.config.performance = process.env.NODE_ENV !== 'production';
Vue.config.devtools = process.env.NODE_ENV !== 'production';

// Register components asynchronously for better performance
Vue.component('example-component', () => import('./components/ExampleComponent.vue'));

// Lazy load admin scripts only when needed
const loadAdminScripts = async () => {
    if (document.querySelector('.admin-panel')) {
        const { default: adminModule } = await import('./admin/main.js');
        return adminModule;
    }
};

// Initialize Vue application with performance optimizations
const app = new Vue({
    el: '#app',
    async mounted() {
        // Load admin scripts if needed
        await loadAdminScripts();
        
        // Initialize search if search elements exist
        if (document.querySelector('.search-container')) {
            const InstantSearch = await loadInstantSearch();
            Vue.use(InstantSearch.default);
        }
    }
});
