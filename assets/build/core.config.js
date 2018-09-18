const baseConfig = require('./_basic.config');
// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = Object.assign(
    {
        name: 'core',
        entry: {
            front: './assets/css/front/front.scss',
            admin: './assets/css/admin/admin.scss',
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: './assets/css/[name]/[name].css'
            }),
        ],
    },
    baseConfig
);