/**
 * Connect dependencies
 */
const mix = require('laravel-mix');
const glob = require('glob');

/**
 * Setup options
 * https://laravel-mix.com/docs/6.0/api#optionsoptions
 */
mix.options({
  processCssUrls: false,
});
mix.disableNotifications();

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

  mix.sourceMaps().webpackConfig({
    devtool: 'inline-source-map',
    plugins: [
      /**
       * Remove assets files(css, js) from build folders
       */
      new CleanWebpackPlugin({
        verbose: true,  // Write Logs to Console (Always enabled when dry is true)
        dry: false, // Simulate the removal of files
        cleanStaleWebpackAssets: false, // Automatically remove all unused webpack assets on rebuild
        protectWebpackAssets: false, // Do not allow removal of current webpack assets
        //Removes files once prior to Webpack compilation Not included in rebuilds (watch mode)
        cleanOnceBeforeBuildPatterns: [
          '**/build/**/*.{css,js}',
          '!vendor/**',
          '!vendor-custom/**',
          '!node_modules/**',
        ],
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
  '{assets/src/**/!(_)*.scss,assets/src/**/*.{js,jsx}}')
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
 * BrowserSync runs on dev mode only
 */
mix.browserSync({
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
  files: [
    '**/*.php',
    '**/*.twig',
    '**/src/**/*.@(scss|js|jsx)',
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
  return process.env.HOST_IP || 'undefined';
}
