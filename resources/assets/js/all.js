// Modern JavaScript imports using installed packages
import 'jquery';
import 'bootstrap';
import '@popperjs/core';
import 'moment';

// Import only the custom scripts that work with Vite
// Removed legacy imports of modernizr.js, typehead.js, and parsley.min.js to avoid errors
// These are now loaded dynamically after jQuery is available
import './admin/jquery.charts.js';
import './admin/script.js';
import './admin/main.js';
