let mix = require('laravel-mix');

// require( 'laravel-mix-tailwind' );
let tailwindcss = require( 'tailwindcss' );

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

mix.js( 'resources/js/app.js', 'public/js' )
   .sass( 'resources/sass/app.scss', 'public/css' )
   .options({

      processCssUrls: false,
      postCss: [ tailwindcss( './tailwind.config.js' ) ],
      autoprefixer: {

         options: {

            browsers: [

               'last 6 versions',
            ]
         }
     }
   })
   // laracasts teaches an <1 version of tailwind, jeffrey's plugin may be inept now
