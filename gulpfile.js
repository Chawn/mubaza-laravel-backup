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

elixir(function(mix) {
    //mix.less('app.less');
    mix.sass('campaign-show.scss', 'public/css/campaign-show2.css');
    mix.scripts([
        '../vendors/jquery/dist/jquery.min.js',
        '../vendors/store2/dist/store2.js',
        '../vendors/moment/moment.js',
        '../vendors/datetimepicker/jquery.datetimepicker.js',
        '../vendors/jquery.countdown/dist/jquery.countdown.min.js'
    ]);
});
