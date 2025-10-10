// Modern JavaScript imports using installed packages
import $ from 'jquery';
import 'bootstrap';
import '@popperjs/core';
import 'moment';

// Expose jQuery globally for legacy scripts
window.jQuery = window.$ = $;

// Import jQuery plugins now that $ is global
import 'datatables.net';
import 'datatables.net-bs5';
import 'typeahead.js';

// Import only the custom scripts that work with Vite
// Removed legacy imports of modernizr.js, typehead.js, and parsley.min.js to avoid errors
// These are now loaded dynamically after jQuery is available
import './admin/jquery.charts.js';
import './admin/script.js';
import './admin/main.js';
