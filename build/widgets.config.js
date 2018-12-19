const baseConfig = require('./_basic.config')();
const path = require('path');
const glob = require('glob');

let dir = path.resolve();

const pathTo = dir.replace(/\\/g, '/') + '/app/Widgets/';
//read all styles.scss from widgets
const stylesArray = glob.sync(pathTo + '**/assets/style.scss');

let assetsObject = stylesArray.reduce((acc, item) => {
	let name = item.replace(pathTo, '');
	name = name.replace('/assets/style.scss', '');
	acc[name] = new Array(item);
	return acc;
}, {});

//read all scripts.js from widgets
const scriptsArray = glob.sync(pathTo + '**/assets/scripts.js');
scriptsArray.reduce((acc, item) => {

	let name = item.replace(pathTo, '');
	name = name.replace('/assets/scripts.js', '');
	if (Array.isArray(assetsObject[name]) === true) {
		assetsObject[name].push(item);
	} else {
		assetsObject[name] = new Array(item);
	}
	return acc;
}, {});

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

baseConfig.plugins.push(
	new MiniCssExtractPlugin({
		filename: '[name]/assets/style.css'
	})
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
);

baseConfig.output = {
	path: dir + '/app/Widgets/',
	filename: '[name]/assets/scripts.min.js'
};

module.exports = Object.assign(
	{
		name: 'widgets',
		entry: assetsObject,
	},
	baseConfig
);
