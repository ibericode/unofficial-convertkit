const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const PrettierPlugin = require('prettier-webpack-plugin');
const StylelintPlugin = require('stylelint-webpack-plugin');
const path = require('path');

module.exports = {
	entry: {
		'js/block-form': ['./js/BlockForm.js'],
		'css/admin': ['./scss/admin.scss'],
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
						},
					},
				],
			},
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							url: false,
							importLoaders: 2,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							plugins: require('@wordpress/postcss-plugins-preset'),
						},
					},
					'sass-loader',
				],
			},
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
		}),
		new DependencyExtractionWebpackPlugin({
			outputFormat: 'php',
			combineAssets: true,
		}),
		new PrettierPlugin(),
		new StylelintPlugin(),
	],
	watchOptions: {
		poll: true,
		ignored: /node_modules/,
	},
};
