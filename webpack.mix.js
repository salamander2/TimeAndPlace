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

mix.js([
        'resources/js/app.js',
        'node_modules/styled-notifications/dist/notifications.js'
    ], 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps(); //needed to prevet bootstrap/popper.map.js warnings

mix.sass('resources/sass/nf_style.scss', 'public/css/notifications.css');
mix.copy('resources/sass/terminal.css', 'public/css/terminal.css');
mix.copy('resources/sass/myStyle.css', 'public/css/myStyle.css');
