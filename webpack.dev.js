const { merge } = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');
const ip = require('ip');
const webpack = require(
    'webpack'
);

const port = parseInt( process.env.PORT, 10 ) || 3030;
const public = `http://${ ip.address() }:${ port }`;

module.exports = merge(common, {
    mode: 'development',
    devtool: 'cheap-module-eval-source-map',
    entry: {
        'js/hr-entries': [
            'react-hot-loader/patch',
            'webpack-hot-middleware/client'
        ]
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
        overlay: true,
        hot: true,
        host: '0.0.0.0',
        writeToDisk: true,
        public,
        port,
        historyApiFallback: true,
        contentBase: path.resolve(__dirname, 'dist/dev')
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
    ],
});