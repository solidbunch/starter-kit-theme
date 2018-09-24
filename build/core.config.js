const baseConfig = require('./_basic.config')();
// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

baseConfig.plugins.push(
    new MiniCssExtractPlugin({
        filename: './assets/css/[name]/[name].css',
    }));

module.exports = Object.assign(
    {
        name: 'core',
        entry: {
            front: './assets/css/front/front.scss',
            libs: './assets/css/libs/libs.scss',
            admin: './assets/css/admin/admin.scss',
            main : './assets/js/main.js',
        },
    },
    baseConfig
);