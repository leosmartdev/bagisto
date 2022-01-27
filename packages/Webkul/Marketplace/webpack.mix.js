const mix = require("laravel-mix");

if (mix == 'undefined') {
    const { mix } = require("laravel-mix");
}

require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = 'publishable/assets';
} else {
    var publicPath = '../../../public/vendor/webkul/marketplace/assets';
}

mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.js([__dirname + '/src/Resources/assets/js/app.js'], 'js/marketplace.js')
    .copyDirectory(__dirname + '/src/Resources/assets/images', publicPath + "/images")
    .sass(__dirname + '/src/Resources/assets/sass/default.scss', 'css/marketplace-default.css')
    .sass(__dirname + '/src/Resources/assets/sass/velocity.scss', 'css/marketplace-velocity.css')
    .sass(__dirname + '/src/Resources/assets/sass/admin.scss', 'css/marketplace-admin.css')
    .options({
        processCssUrls: false
    });


if (! mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}