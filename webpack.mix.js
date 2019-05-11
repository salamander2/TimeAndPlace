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

// mix.styles('node_modules/styled-notifications/dist/notifications.css', 'public/css/notifications.css');
mix.sass('resources/sass/style.scss', 'public/css/notifications.css');
mix.copy('resources/sass/terminal.css', 'public/css/terminal.css');


/* Should I add this too? */
// webpack.mix.js
//mix.js('./resources/js/bootstrap.js', './public/js/app.js')
//  .sass('resources/assets/sass/vendor.scss', './public/css/vendor.css')
//  .sass('resources/assets/sass/theme.scss', './public/css/app.css')

//mix.copy('vendor/bootstrap-calendar/css', 'public/bootstrap-calendar/css');

mix.scripts('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js');
//mix.scripts('node_modules/admin-lte/dist/js/adminlte.min.js', 'public/js/adminlte.min.js');
//#mix.scripts('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js');
//mix.scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js/bootstrap.bundle.min.js');

mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js');



//then run "npm run dev"
//then restart artisan server (if running on localhost)
