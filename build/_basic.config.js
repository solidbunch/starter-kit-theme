const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

module.exports = function () {
	const baseConf = {
		externals: {
			jquery: 'jQuery'
		},
		optimization: {
			minimizer: [
				// enable the
				// js minification plugin
				new UglifyJSPlugin({
					test: /\.js(\?.*)?$/i,
					sourceMap: false,
					extractComments: true,
					parallel: true,
					uglifyOptions: {
						warnings: false,
						compress: {
							unsafe: true,
							inline: true,
							passes: 2,
							keep_fargs: false,
						},
						mangle: true, // Note `mangle.properties` is `false` by default.
						output: {
							beautify: false,
						},
						toplevel: false,
						ie8: false,
					}
				}),
				//enable the css minification plugin
				new OptimizeCSSAssetsPlugin()
			]
		},
		output: {
			path: path.resolve(),
			filename: "./dist/js/[name].min.js"
		},
		module: {
			rules: [
				//images loader
				{
					test: /\.(png|jpg|jpeg|svg|gif)$/i,
					exclude: [ path.resolve('node_modules/'), path.resolve('assets/fonts/') ],
					use: [{
						loader: 'file-loader',
						options: {
							outputPath: './dist/img/',    // where the fonts will go
							publicPath: '../img/',
							name: '[name]-[hash].[ext]'
						}
					}]
				},
				// fonts loader
				{
					test: /.(ttf|otf|svg|eot|woff(2)?)(\?[a-z0-9]+)?$/,
					exclude: path.resolve('assets/images/'),
					use: [{
						loader: 'file-loader',
						options: {
							outputPath: './dist/fonts/',    // where the fonts will go
							publicPath: '../fonts/',       // override the default path
							name: '[name]-[hash].[ext]',
						}
					}]
				},
				// compile all .scss files to plain old css
				{
					test: /\.(sass|scss)$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								sourceMap: true,
							}
						},
						{loader: 'sass-loader', options: {sourceMap: true}},
					]
				},
				//babel
				{
					test: /\.js$/,
					exclude: /(node_modules|bower_components)/,
					use: {
						loader: 'babel-loader',
					}
				}
			]
		},
		devtool: 'source-map',
		plugins: [
			new FixStyleOnlyEntriesPlugin({
				silent: true
			})
		],
	};

	const fs = require('fs');

	if (process.env.SYNC === "true" && fs.existsSync('./build/browser-sync.config.js') && !process.isBrowserSyncAdded) {
		const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
		const config = require('./browser-sync.config');

		baseConf.plugins.push(new BrowserSyncPlugin(config));
		process.isBrowserSyncAdded = true;
	}


	return baseConf;
};
