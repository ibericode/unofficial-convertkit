const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const path = require('path');

module.exports = {
    entry: {
        "js/block-form": "./js/blockForm.js"
    },
    context: path.resolve(__dirname, 'assets/'),
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    'babel-loader',
                    {
                        loader: 'eslint-loader',
                        options: {
                            emitWarning: true,
                        }
                    }
                ],
            },
        ],
    },
    output: {
        filename: '[name].js',
    },
    plugins: [
        new CleanWebpackPlugin({
            verbose: true,
            protectWebpackAssets: false,
            cleanOnceBeforeBuildPatterns: [
                '**/*'
            ],
            cleanAfterEveryBuildPatterns: [
                // '**/*.asset.php',
            ],
        }),
        new DependencyExtractionWebpackPlugin({
            injectPolyfill: true,
            outputFormat: "php"
        }),
    ],
    watchOptions: {
        poll: true,
        ignored: /node_modules/,
    }
};