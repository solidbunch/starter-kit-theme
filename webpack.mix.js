const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const outPutPath = "assets/fonts/block-icons";

/**
 * Настройки Mix
 */
mix.options({
  processCssUrls: false,
});
mix.disableNotifications();

mix.webpackConfig({
  entry: [
    './entry.js'
  ],
  output: {
    path: path.resolve(__dirname, outPutPath),
    publicPath: '/',
    filename: 'app.bundle.js'
  },
  performance: {
    hints: false
  },
  module: {
    rules: [
      {
        test: /\.font\.js/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              url: false
            }
          },
          require.resolve('webfonts-loader') // Replace this line with require('webfonts-loader')
        ]
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'app.bundle.[contenthash].css'
    })
  ]
});

/**
 * Настройки для dev-режима
 */
if (!mix.inProduction()) {
  const {CleanWebpackPlugin} = require('clean-webpack-plugin');
  const ESLintWebpackPlugin = require('eslint-webpack-plugin');
  const StylelintWebpackPlugin = require('stylelint-webpack-plugin');

  mix.sourceMaps().webpackConfig({
    devtool: 'inline-source-map',
    plugins: [
      // Очистка build-файлов
      new CleanWebpackPlugin({
        verbose: true,
        dry: false,
        cleanStaleWebpackAssets: false,
        protectWebpackAssets: false,
        cleanOnceBeforeBuildPatterns: [
          '**/build/**/*.{css,js,map,txt}',
          '!vendor/**',
          '!vendor-custom/**',
          '!node_modules/**',
        ],
      }),
      // Проверка кода на соответствие стандартам ESLint
      new ESLintWebpackPlugin({
        fix: false,
        extensions: ['js', 'jsx'],
        overrideConfigFile: '.eslintrc.json',
        failOnError: false,
        cache: true,
      }),
      // Проверка стилей на соответствие стандартам Stylelint
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
 * Чтение файлов и поиск ассетов
 */
const allAssets = glob.sync(
  '{assets/src/styles/!(_)*.scss,assets/src/js/*.{js,jsx}}')
  .concat(
    glob.sync('{blocks/!(_)**/src/!(_)*.scss,blocks/!(_)**/src/*.{js,jsx}}'));

/**
 * Запуск предварительной обработки
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
 * Настройка генерации SVG шрифтов с использованием webfonts-loader
 */

/**
 * BrowserSync на dev-режиме
 */
if (!mix.inProduction()) {
  mix.browserSync({
    proxy: getAppUrl(),
    host: getHostIp(),
    port: 3000,
    open: false,
    files: [
      '**/*.php',
      '**/*.twig',
      '**/src/**/*.@(scss|js|jsx)',
    ],
  });
}

/**
 * Вспомогательные функции
 */
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
