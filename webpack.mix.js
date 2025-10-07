const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .extract(['jquery', 'axios', 'lodash'])
   .options({
       processCssUrls: false
   });

mix.styles([
    'node_modules/froala-editor/css/froala_editor.pkgd.min.css',
    // 'public/admin/css/login.css',
    'public/admin/css/style4.css',
    'public/admin/css/style.css',
    'public/admin/css/bar.css',
    'public/admin/css/widgets.css',
    ],
    'public/css/all.css');


mix.scripts([
    'public/admin/js/jquery-2.2.3.min.js',
    'node_modules/froala-editor/js/froala_editor.pkgd.min.js',
    'public/admin/js/typehead.js',
    'public/admin/js/script.js',
    'public/admin/js/main.js',
    ],

    'public/js/all.js');

mix.scripts([
        'public/admin/js/typehead.js',
    ],

    'public/js/typehead.js');

