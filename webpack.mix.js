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

mix
    .js('resources/js/app.js', 'public/js').version().extract([
    'jquery',
    'bootstrap',
    'icon-picker',
    'fontawesome-free',
    'dark-mode-switch',
    'bootstrap-iconpicker',
    'chart',
    'toastify-js'
])
    .sass('resources/sass/app.scss', 'public/css').version()
    .copyDirectory('resources/img', 'public/images')
    .browserSync({
        proxy: 'http://localhost/',
        open: false,
    })
    .sourceMaps();