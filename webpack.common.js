const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const path = require('path');

module.exports = {
    entry: {
        "js/block-form": "./js/BlockForm.js"
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
            },
        ],
    },
    output: {
        filename: '[name].js',
    },
    plugins: [
        new CleanWebpackPlugin({
            verbose: true,
        }),
    ],
    watchOptions: {
        poll: true,
        ignored: /node_modules/,
    }
};