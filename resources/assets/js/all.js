// Modern JavaScript imports using installed packages
import 'jquery';
import 'bootstrap';
import '@popperjs/core';
import 'moment';

// Import only the custom scripts that work with Vite
import './admin/modernizr.js';
// Remove moment.min.js import - using package instead
import './admin/parsley.min.js';
import './admin/jquery.charts.js';
import './admin/script.js';
import './admin/main.js';