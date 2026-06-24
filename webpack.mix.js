const mix = require('laravel-mix');
const dotenv = require('dotenv');
const dotenvExpand = require('dotenv-expand');

// Load environment variables from .env.production if building for production
if (mix.inProduction()) {
    const env = dotenv.config({ path: '.env.production', override: true });
    dotenvExpand(env);
}

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
mix.disableNotifications();

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');
