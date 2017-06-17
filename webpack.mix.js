const { mix } = require('laravel-mix');

var LiveReloadPlugin = require('webpack-livereload-plugin');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
});
