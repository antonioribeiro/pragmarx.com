const { mix } = require('laravel-mix');

let tailwindcss = require('tailwindcss');

let LiveReloadPlugin = require('webpack-livereload-plugin');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .options({
       processCssUrls: false,
       postCss: [
           tailwindcss('./tailwind.js'),
       ]
   })
;

mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
});
