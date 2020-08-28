const {merge} = require('webpack-merge');
const common = require('./webpack.common.js');
const path = require('path');
const ip = require('ip');

const port = parseInt(process.env.PORT, 10) || 3030;
const public = `http://${ip.address()}:${port}`;

module.exports = merge(common, {
    mode: 'development',
    devtool: 'cheap-module-eval-source-map',
    output: {
        path: path.resolve(__dirname, 'dist/dev/'),
        publicPath: public + '/dist/dev/',
    },
    devServer: {
        disableHostCheck: true,
        headers: {
            'Access-Control-Allow-Origin': '*'
        },
        inline: true,
        hot: true,
        host: '0.0.0.0',
        writeToDisk: (filepath) => {
            return /^((?!\.hot-update\.).)*$/.test(filepath);
        },
        public,
        port,
        historyApiFallback: true,
        contentBase: path.resolve(__dirname, 'dist/dev')
    }
});