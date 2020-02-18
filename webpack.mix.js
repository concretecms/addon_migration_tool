let mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        jquery: 'jQuery'
    }
});

// Set our public path
mix.setPublicPath('packages/migration_tool/assets');

// Build themes
mix
    .sass('resources/scss/backend/backend.scss', 'css/backend.css')
    .js('resources/js/backend.js', 'js/backend.js');


// Turn off notifications
mix
    .disableNotifications()
    .options({
        clearConsole: false,
    })
