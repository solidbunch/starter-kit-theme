const baseConfig = require('./_basic.config');

const glob = require('glob');
//read all styles.scss from shortcodes
const stylesArray = glob.sync('./core/shortcodes/**/assets/style.scss');
const stylesObject = stylesArray.reduce((acc, item) => {
    let name = item.replace('./core/shortcodes/', '');
    name = name.replace('/assets/style.scss', '');
    acc[name] = item;
    return acc;
}, {});

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

return {
    entry:stylesObject,
    plugins: [
        new MiniCssExtractPlugin({
            filename: './core/shortcodes/[name]/assets/style.css'
        }),
    ],
    baseConfig
};