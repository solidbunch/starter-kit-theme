const baseConfig = require('./_basic.config');

const glob = require('glob');
//read all styles.scss from widgets
const stylesArray = glob.sync('./core/widgets/**/assets/style.scss');
const stylesObject = stylesArray.reduce((acc, item) => {
    let name = item.replace('./core/widgets/', '');
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
            filename: './core/widgets/[name]/assets/style.css'
        }),
    ],
    baseConfig
};