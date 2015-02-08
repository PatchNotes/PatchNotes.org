var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.less('app.less');

    mix.copy('./resources/assets/libraries/fontawesome/fonts', './public/fonts');

    mix.scripts([
        'libraries/jquery/dist/jquery.js',
        'libraries/jquery-textfill/source/jquery.textfill.js',
        'libraries/bootstrap/dist/js/bootstrap.js'
    ], './public/js/libs.js', './resources/assets');

    mix.scripts([
        'js/patchnotes.js'
    ], './public/js/app.js', './resources/assets');


    mix.version(['css/app.css','js/app.js','js/libs.js']);
});
