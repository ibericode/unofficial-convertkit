const {CleanWebpackPlugin} = require('clean-webpack-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const path = require('path');

module.exports = {
    entry: {
        'js/block-form': './js/BlockForm.js',
        'css/admin': ['./scss/admin.scss']
    },
    context: path.resolve(__dirname, 'assets/'),
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
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
                include: [
                    path.resolve(__dirname, 'assets/')
                ],
            },
            {
                test:  /\.s[ac]ss$/i,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            hrm: false
                        }

                    },
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            plugins: require('@wordpress/postcss-plugins-preset')
                        }
                    },
                    'sass-loader'
                ]
            }
        ],
    },
    output: {
        filename: '[name].js',
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
        }),
        new FixStyleOnlyEntriesPlugin(),
        new CleanWebpackPlugin({
            verbose: true,
            cleanAfterEveryBuildPatterns: [
                /^((?!\.hot-update\.).)*$/
            ]
        }),
        new DependencyExtractionWebpackPlugin({
            outputFormat: "php",
            combineAssets: true
        }),
    ],
    watchOptions: {
        poll: true,
        ignored: /node_modules/,
    }
};