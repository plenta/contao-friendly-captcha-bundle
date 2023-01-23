var Encore = require('@symfony/webpack-encore');
var bundleName = 'PlentaContaoFriendlyCaptchaBundle';

Encore
    .setOutputPath('src/Plenta/ContaoFriendlyCaptchaBundle/Resources/public/webpack')
    .setPublicPath('/bundles/plentacontaofriendlycaptcha/webpack')
    .setManifestKeyPrefix('plentafriendlycaptcha')
    .addExternals({
        jquery: 'jQuery'
    })

    .addEntry('friendlyCaptcha', './assets-webpack/js/friendlyCaptcha.js')

    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    //.enableSingleRuntimeChunk()
    .disableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    //.enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    //.enableSassLoader()
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    /*.configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })*/
    .configureBabel(function(babelConfig) {
        babelConfig.plugins.push('@babel/plugin-transform-runtime');
    }, {})
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
