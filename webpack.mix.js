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

require('mix-env-file');

// Then pass your file to this plugin
// If this is not set, this plugin won't do anything and the default .env variables will remain
mix.env(process.env.ENV_FILE);

const fs = require('fs');
const path = require('path');

mix.setPublicPath("public");
mix.setResourceRoot("../");

mix.scripts([
    'resources/js/utillities.js',
], 'public/js/utillities.js').version();


mix.scripts([
    'resources/js/controls.js',
], 'public/js/controls.js').version();


mix.scripts([
    'resources/js/automations.js',
], 'public/js/automations.js').version();


mix.scripts([
    'resources/js/locations-controller.js',
], 'public/js/locations-controller.js').version();


mix.scripts([
    'resources/js/developments-controller.js',
], 'public/js/developments-controller.js').version();


mix.scripts([
    'resources/js/notifications.js',
], 'public/js/notifications.js').version();


mix.scripts([
    'resources/js/locators.js',
], 'public/js/locators.js').version();


mix.scripts([
    'resources/js/serviceworker.js',
], 'public/serviceworker.js').after(stats => {
    // webpack compilation has completed
    fs.readFile(path.resolve(__dirname, 'public/serviceworker.js'), 'utf8', (readError, data) => {
        if (readError) {
            console.error("\x1b[31mError: \x1b[0m" + readError);
            return;
        }

        var result = data.replace('process.env.MIX_FIREBASE_MESSAGING_SENDER_ID', process.env.MIX_FIREBASE_MESSAGING_SENDER_ID);

        fs.writeFile(path.resolve(__dirname, 'public/serviceworker.js'), result, writeError => {
            if (writeError) {
                console.error("\x1b[31mError: \x1b[0m" + writeError);
                return;
            }

            console.log("Relative theme directory references replaced to full urls!");
        });
    })
}).version();

mix.minify('public/serviceworker.js').version();

mix.scripts([
    'resources/js/push-notifications.js',
], 'public/js/push-notifications.js').version();


mix.scripts([
    'resources/js/refresh-csrf.js',
], 'public/js/refresh-csrf.js')
    .version();

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
