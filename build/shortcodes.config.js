const baseConfig = require('./_basic.config')();
const path = require('path');
const glob = require('glob');
const pathTo = path.resolve(__dirname + "/../") + '/core/shortcodes/';
//read all styles.scss from shortcodes

const stylesArray = glob.sync(pathTo + '**/assets/style.scss');

const stylesObject = stylesArray.reduce((acc, item) => {
    let name = item.replace(pathTo, '');
    name = name.replace('/assets/style.scss', '');
    acc[name] = item;
    return acc;
}, {});


// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

baseConfig.plugins.push(
    new MiniCssExtractPlugin({
    filename: './core/shortcodes/[name]/assets/style.css'
}));

module.exports = Object.assign(
    {
        name: 'shortcodes',
        entry: stylesObject,
    },
    baseConfig
);