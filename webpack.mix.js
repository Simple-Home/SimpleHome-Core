const mix = require("laravel-mix");
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

mix.setPublicPath("public");
mix.setResourceRoot("../");

mix.scripts([
    'resources/js/utillities.js',
], 'public/js/utillities.js');

mix.scripts([
    'resources/js/controls.js',
], 'public/js/controls.js');

mix.scripts([
    'resources/js/automations.js',
], 'public/js/automations.js');

mix.scripts([
    'resources/js/locations.js',
], 'public/js/locations.js');

mix.scripts([
    'resources/js/developments-controller.js',
], 'public/js/developments-controller.js');

mix.scripts([
    'resources/js/notifications.js',
], 'public/js/notifications.js');

mix.scripts([
    'resources/js/locators.js',
], 'public/js/locators.js');

mix.scripts([
    'resources/js/serviceworker.js',
], 'public/serviceworker.js');

mix.scripts([
    'resources/js/push-notifications.js',
], 'public/js/push-notifications.js');

mix.scripts([
    'resources/js/refresh-csrf.js',
], 'public/js/refresh-csrf.js');

mix.js("resources/js/app.js", "public/js")
    .version()
    .extract([
        "jquery",
        "popper",
        "bootstrap",
        "icon-picker",
        "fontawesome-free",
        "dark-mode-switch",
        "bootstrap-iconpicker",
        "chart",
        "toastify-js",
    ])
    .sass("resources/sass/app.scss", "public/css")
    .version()
    .copyDirectory("resources/img", "public/images")
    .copyDirectory("public/fonts/vendor", "public")
    .browserSync({
        proxy: "http://localhost/",
        open: false,
    })
    .sourceMaps();
