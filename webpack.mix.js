/**
 * Connect dependencies
 */
const mix = require('laravel-mix');
const glob = require('glob');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const createJsonVariables = require('./webpack/createJsonVariables');
const path = require('path');
const customScssVariablesPath = path.join(__dirname, 'assets/src/styles/custom_bootstrap', '_custom_variables.scss');
const customJsonVariablesPath = path.join(__dirname, 'assets/build', 'variables.json');
/**
 * Setup options
 * https://laravel-mix.com/docs/6.0/api#optionsoptions
 */

mix.options({
  processCssUrls: false,
});

mix.disableNotifications();

// createJsonVariables(customScssVariablesPath, customJsonVariablesPath);

function applyFontRule(fontPath) {
  mix.js(`webfonts-loader/${fontPath}.font.js`, `assets/build/fonts/${fontPath}`)
    .webpackConfig({
      devtool: false,
      module: {
        rules: [
          {
            test: /webfonts-loader\/.*\.font\.js$/,
            use: [
              {loader: MiniCssExtractPlugin.loader},
              {
                loader: 'css-loader',
                options: {url: false, sourceMap: false},
              },
              {loader: 'webfonts-loader'},
            ],
          },
        ],
      },
    });
}

applyFontRule('block-icons');
applyFontRule('icons');

mix.webpackConfig({
  plugins: [
    new (class {
      apply(compiler) {
        // Для режима watch
        compiler.hooks.watchRun.tap('UpdateVariablesPlugin', (compilation) => {
          console.log('Detected file changes (watch mode), running updateVariables...');
          createJsonVariables(customScssVariablesPath, customJsonVariablesPath);
        });
        // Для обычной сборки (production или development)
        compiler.hooks.beforeRun.tap('UpdateVariablesPlugin', (compilation) => {
          console.log('Starting a new build (prod or dev mode), running updateVariables...');
          createJsonVariables(customScssVariablesPath, customJsonVariablesPath);
        });
      }
    })()
  ],
  devtool: false
});
/**
 * Setup options for dev mode
 * In main ESLint config we can use 'overrides' for special files. For example:
 *     'overrides': [
 *         {
 *             'env': {
 *                 'node': true
 *             },
 *             'files': [
 *                 'some-file.{js,jsx}'
 *             ],
 *             'parserOptions': {
 *                 'sourceType': 'script'
 *             },
 *            'rules': {
 *              'indent': [
 *                'error',
 *                4
 *              ]
 *            }
 *         }
 *     ]
 */
if (!mix.inProduction()) {
  const {CleanWebpackPlugin} = require('clean-webpack-plugin');
  const ESLintWebpackPlugin = require('eslint-webpack-plugin');
  const StylelintWebpackPlugin = require('stylelint-webpack-plugin');
  const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

  mix.sourceMaps();

  mix.webpackConfig({
    devtool: 'inline-source-map', // or 'source-map'
    /*
    * Watcher runs on dev mode only
    */
    watchOptions: {
      ignored: /node_modules|.*\/build\//, // Ignore node_modules, build directories, and all except specified directories
      aggregateTimeout: 1, // Delay before rebuilding after changes are detected
      poll: 1 // Interval for polling for file changes
    },
    plugins: [
      /**
       *Remove assets files(css, js) from build folders
       */
      new CleanWebpackPlugin({
        verbose: true,// Write Logs to Console (Always enabled when dry is true)
        dry: false,// Simulate the removal of files
        cleanStaleWebpackAssets: false,// Automatically remove all unused webpack assets on rebuild
        protectWebpackAssets: false,// Do not allow removal of current webpack assets
        //Removes files once prior to Webpack compilation Not included in rebuilds (watch mode)
        cleanOnceBeforeBuildPatterns: [
          '**/build/**/*.{css,js,map,txt}',
          '!vendor/**',
          '!vendor-custom/**',
          '!node_modules/**',
        ],
      }),
      /**
       * BrowserSync runs on dev mode only
       */
      new BrowserSyncPlugin({
        /**
         * Proxying to nginx container with alias APP_DOMAIN
         * Proxy should be the same as WP_SITEURL in wp-config.php
         */
        proxy: getAppUrl(),
        /**
         * Set external host network IP.
         * If hostIp is undefined, just find your local network IP in your system
         * and use it in your other devices browser to sync with BrowserSync.
         */
        host: getHostIp(),
        port: 3000,
        open: false,
        /**
         * No files will be tracked, browser reloads after assets was build.
         */
        files: [],
      }),
      /**
       * Code QA
       */
      new ESLintWebpackPlugin({
        fix: false,
        extensions: ['js', 'jsx'],
        overrideConfigFile: '.eslintrc.json',
        failOnError: false,
        cache: true,
      }),
      new StylelintWebpackPlugin({
        fix: false,
        extensions: ['scss'],
        configFile: '.stylelintrc.json',
        failOnError: false,
        files: [
          'assets/src/**/*.scss',
          'blocks/!(_)**/src/*.scss',
        ],
        cache: true,
      }),
    ],
  });

  function getAppUrl() {
    const appProtocol = process.env.APP_PROTOCOL;
    const appDomain = process.env.APP_DOMAIN;

    let appPort = '';

    if (appProtocol === 'https') {
      appPort = process.env.APP_HTTPS_PORT;
    } else {
      appPort = process.env.APP_HTTP_PORT;
    }

    let appUrl = appProtocol + '://' + appDomain;

    if (appPort !== '80' && appPort !== '443') {
      appUrl += ':' + appPort;
    }

    return appUrl;
  }

  function getHostIp() {
    return process.env.HOST_IP || 'your.local.network.ip';
  }
}

/**
 * Read the folders and look for assets files.
 *
 * Files with names start with '_' will be ignored
 * For example, 'partials/_body.scss' just need to include to main file
 *
 * Block folders that names start with '_' will be ignored too.
 * Example, '_StarterBlock' - should not be registered
 */
const allAssets = glob.sync(
  '{assets/src/styles/!(_)*.scss,assets/src/js/*.{js,jsx},assets/src/js/bootstrap/*.{js,jsx}}')
  .concat(
    glob.sync('{blocks/!(_)**/src/!(_)*.scss,blocks/!(_)**/src/*.{js,jsx}}'));

/**
 * Run Preprocessing
 */
allAssets.forEach(assetPath => {
  if (assetPath.endsWith('.scss')) {
    mix.sass(
      assetPath,
      assetPath
        .replace(/\/src\//, '/build/')
        .replace(/\\src\\/, '\\build\\')
        .replace(/\.(scss)$/, '.css'),
    );
  } else if (assetPath.endsWith('.js') || assetPath.endsWith('.jsx')) {
    mix.js(
      assetPath,
      assetPath
        .replace(/\/src\//, '/build/')
        .replace(/\\src\\/, '\\build\\')
        .replace(/\.(jsx)$/, '.js'),
    );
  }
});
/**
 * Watch custom SCSS variables file
 */
// mix.then(() => {
//   fs.watch(customScssVariablesPath, (eventType, filename) => {
//     if (filename && eventType === 'change') {
//       console.log(`${filename} file changed, running createJsonVariables...`);
//       createJsonVariables(customScssVariablesPath, customJsonVariablesPath);
//     }
//   });
//   // console.log('start  then');
// });
