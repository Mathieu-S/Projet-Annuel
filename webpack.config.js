var Encore = require('@symfony/webpack-encore');

Encore
    // Global config
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()

    // Entries
    .addEntry('app', './resources/assets/ts/main.ts')
    .addStyleEntry('global', './resources/assets/scss/global.scss')
    .addStyleEntry('backoffice', './resources/assets/scss/backoffice.scss')

    // Loaders
    .enableSassLoader()
    .enableTypeScriptLoader(function (typeScriptConfigOptions) {
        typeScriptConfigOptions.transpileOnly = true;
        typeScriptConfigOptions.configFile = 'tsconfig.json';
    })
    .enableVueLoader(function(options) {
        options.loaders = {
            i18n: '@kazupon/vue-i18n-loader'
        }
    })

    // Other options
    .autoProvidejQuery()

    // Build config
    .enableSourceMaps(!Encore.isProduction())
    // .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
