var elixir = require('laravel-elixir');
var path = require('path');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less')
        .webpack('app.js', null, null, {
            resolve: {
                modules: [
                    path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js'),
                    'node_modules'
                ]
            }
        })
        .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')
        .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css');
});
