const baseConfig = require('./_basic.config')();
// include the css extraction and minification plugins
const MiniCssExtractPlugin	= require("mini-css-extract-plugin");
const BrowserSyncPlugin 	= require('browser-sync-webpack-plugin');

baseConfig.plugins.push(
	new MiniCssExtractPlugin({
		filename: './assets/css/[name]/[name].css',
	}),
	new BrowserSyncPlugin({
		host: 'localhost',
		port: 3000,
		proxy: 'http://blank.lc' // your local domain
	})
);

baseConfig.module.rules.push(
	// fonts loader
	{
		test: /\.(png|jpg|svg|gif)$/i,
		use: [{
			loader: 'file-loader',
			options: {
				name: '[name].[ext]',
				outputPath: './assets/images/',    // where the fonts will go
				publicPath: '../../images/'       // override the default path
			}
		}]
	},
	// fonts loader
	{
		test: /.(ttf|otf|eot|woff(2)?)(\?[a-z0-9]+)?$/,
		use: [{
			loader: 'file-loader',
			options: {
				name: '[name].[ext]',
				outputPath: './assets/fonts/',    // where the fonts will go
				publicPath: '../../fonts/'       // override the default path
			}
		}]
	}
);

module.exports = Object.assign(
	{
		name: 'core',
		entry: {
			app: './assets/js/app.js',
			front: './assets/css/front/front.scss',
			libs: './assets/css/libs/libs.scss',
			admin: './assets/css/admin/admin.scss',
		}
	},
	baseConfig
);
