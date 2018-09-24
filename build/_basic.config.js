const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');
const autoprefixer = require('autoprefixer');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");

module.exports = function () {
    const baseConf = {
        optimization: {
            minimizer: [
                // enable the js minification plugin
                new UglifyJSPlugin({
                    test: /\.js(\?.*)?$/i,
                    sourceMap: false,
                    extractComments: true
                }),
                //enable the css minification plugin
                new OptimizeCSSAssetsPlugin({
                    cssProcessor: require('cssnano'),
                    cssProcessorPluginOptions: {
                        preset: ['default', {discardComments: {removeAll: true}}],
                    }
                })
            ]
        },
        output: {
            path: path.resolve(__dirname + " /../"),
            filename: "./assets/js/[name].min.js"
        },
        module: {
            rules: [
                // compile all .scss files to plain old css
                {
                    test: /\.(sass|scss)$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        {loader: 'css-loader', options: {sourceMap: true}},
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true,
                                plugins: () => [autoprefixer({
                                    'browsers': ['last 5 versions', '> 1%', 'ie 11']
                                })]
                            }
                        },
                        {loader: 'sass-loader', options: {sourceMap: true}},
                    ]
                },
                // fonts loader
                {
                    test: /.(ttf|otf|eot|svg|woff(2)?)(\?[a-z0-9]+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: './assets/fonts/',    // where the fonts will go
                            publicPath: '../../fonts/'       // override the default path
                        }
                    }]
                },
                //babel
                {
                    test: /\.m?js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }
            ]
        },
        devtool: 'source-map',
        plugins: [
            new FixStyleOnlyEntriesPlugin(),
        ],
    };

    const fs = require('fs');
    if (process.env.SYNC === "true" && fs.existsSync('./broswer-sync.config') ) {
        const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
        baseConf.plugins.push(
            new BrowserSyncPlugin(
                require('./broswer-sync.config')
            ),
        )
    }

    return baseConf;
};