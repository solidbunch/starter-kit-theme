//helper fu

const path = require('path');
const glob = require("glob");
// include the js minification plugin
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const stylesArray = glob.sync('./core/shortcodes/**/assets/style.scss');
const stylesObject = stylesArray.reduce((acc, item) => {
    let name = item.replace('./core/shortcodes/', '');
    name = name.replace('/assets/style.scss', '');
    acc[name] = item;
    return acc;
}, {});
module.exports = {
    // entry: {
    //     front : './assets/css/front/front.scss',
    //     admin :'./assets/css/admin/admin.scss',
    // },
    entry: stylesObject,
    optimization: {
        minimizer: [
            // enable the js minification plugin
            new UglifyJSPlugin({
                cache: true,
                parallel: true
            }),
            //enable the css minification plugin
            new OptimizeCSSAssetsPlugin({
                cssProcessor: require('cssnano'),
                cssProcessorPluginOptions: {
                    preset: ['default', { discardComments: { removeAll: true } }],
                },
                canPrint: true
            })
        ]
    },
    output: {
        path: path.resolve(__dirname),
        filename: "./assets/js/build/[name].js"
    },
    module: {
        rules: [
            //svg loader
            {
                test: /\.svg$/,
                loader: 'svg-inline-loader'
            },
            // compile all .scss files to plain old css
            {
                test: /\.(sass|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: './assets/css/[name]/[name].css'
        }),
    ]
};