const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');
const HotModuleReplacementPlugin = require('webpack').HotModuleReplacementPlugin;
const ManifestPlugin = require( 'webpack-manifest-plugin' );
const onExit = require( 'signal-exit' );

const port = parseInt( process.env.PORT, 10 ) || 3030;
const publicPath = `http://localhost:${ port }/dist/dev/`;

onExit(() => {
    try {
        path.unlinkSync( 'dist/dev/asset-manifest.json' );
    } catch {
        // Silently ignore unlinking errors: so long as the file is gone, that is good.
    }
})

module.exports = merge(common, {
    mode: 'development',
    output: {
        pathinfo: false,
        path: path.resolve(__dirname, 'dist/dev/'),
        publicPath
    },
    devServer: {
        disableHostCheck: true,
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
        hotOnly: true,
        watchOptions: {
            aggregateTimeout: 300,
        },
        stats: {
            all: false,
            assets: true,
            colors: true,
            errors: true,
            performance: true,
            timings: true,
            warnings: true,
        },
        port,
    },
    module: {
        strictExportPresence: true,
    },
    plugins: [
        new DependencyExtractionWebpackPlugin({
            injectPolyfill: false,
            outputFormat: "json"
        }),
        new ManifestPlugin({
            fileName: 'asset-manifest.json',
            writeToFileEmit: true,
            publicPath,
        }),
        new HotModuleReplacementPlugin()
    ],
});