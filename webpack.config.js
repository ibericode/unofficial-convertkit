const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { SourceMapDevToolPlugin } = require( 'webpack' );
const path = require('path');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = {
    mode: 'production',
    entry: {
    //    ToDo: add entries
    },
    context: path.resolve(__dirname, 'assets'),
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
        path: __dirname + '/dist/',
    },
    optimization: {
        minimize: true,
        minimizer: [
            new UglifyJsPlugin({
                include: /\.min\.js$/,
                sourceMap: true,
            }),
        ],
    },
    plugins: [
        new CleanWebpackPlugin({
            verbose: true,
            protectWebpackAssets: false,
            cleanOnceBeforeBuildPatterns: [],
            cleanAfterEveryBuildPatterns: [
                '**/*.asset.json',
                '**/*.asset.php',
            ],
        }),
        new SourceMapDevToolPlugin({
            filename: '[file].map',
        }),
        new DependencyExtractionWebpackPlugin(),
    ],
    watchOptions: {
        poll: true,
        ignored: /node_modules/,
    },
};