const baseConfig = require('./_basic.config')();
// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');


baseConfig.plugins.push(
	new MiniCssExtractPlugin({
		filename: './dist/css/[name].css',
	}),
	new CleanWebpackPlugin(path.resolve('dist') , {
		root: path.resolve()
	}),
);

module.exports = Object.assign(
	{
		name: 'app',
		entry: {
			app: './assets/js/app.js',
			front: './assets/css/front/front.scss',
			libs: './assets/css/libs/libs.scss',
			admin: './assets/css/admin/admin.scss',
		},
	},
	baseConfig
);
