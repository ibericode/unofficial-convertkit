const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const path = require('path');
const ip = require('ip');
const webpack = require(
    'webpack'
);

const port = parseInt( process.env.PORT, 10 ) || 3030;
const public = `http://${ ip.address() }:${ port }`;

module.exports = merge(common, {
    mode: 'development',
    entry: {
        'js/hr-entries': [
            'react-hot-loader/patch',
            'webpack/hot/only-dev-server',
            `webpack-dev-server/client?${public}`,
        ],
    },
    output: {
        pathinfo: false,
        path: path.resolve(__dirname, 'dist/dev/'),
        publicPath: public + '/dist/dev/',
    },
    devServer: {
        disableHostCheck: true,
        headers: {
            'Access-Control-Allow-Origin': '*'
        },
        hot: true,
        host: '0.0.0.0',
        writeToDisk: true,
        public,
        port
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
        new DependencyExtractionWebpackPlugin({
            outputFormat: "php",
        })
    ],
});