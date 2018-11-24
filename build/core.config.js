const baseConfig = require('./_basic.config')();
// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const path = require('path');


baseConfig.plugins.push(
	new MiniCssExtractPlugin({
		filename: './assets/css/[name]/[name].css',
	}),
);

baseConfig.module.rules.push(
	// images loader
	{
		test: /\.(png|jpg|svg|gif)$/i,
		exclude: path.resolve('node_modules/'),
		use: [{
			loader: 'url-loader',
			options: {
				limit: 9999999999
			}
		}]
	},
	// fonts loader
	{
		test: /.(ttf|otf|svg|eot|woff(2)?)(\?[a-z0-9]+)?$/,
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
		name: 'app',
		entry: {
			app: './assets/js/app.js',
			front: './assets/css/front/front.scss',
			libs: './assets/css/libs/libs.scss',
			admin: './assets/css/admin/admin.scss',
		}
	},
	baseConfig
);
