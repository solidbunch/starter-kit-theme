module.exports = {
  'files': [
    '../assets/images/block-icons/*.svg'
  ],
  'html':true,
  'cssTemplate':'template-css.hbs',
  'fontName': 'block-icons',
  'classPrefix': 'sk-',
  'baseSelector': '.sk',
  'types': ['eot', 'woff', 'woff2', 'ttf', 'svg'],
  'fixedWidth': true,
  'fileName': 'app.[fontname].[ext]',

  // 'dest':'public',
  // 'cssFontsPath':'public/fonts'
  // 'publicPath':' ',
  // 'outputPath': './'
  'dest': 'MyTest', // Указываем каталог, куда сохранять шрифты
  // 'cssFontsPath': '../fonts', // Указываем путь к шрифтам в CSS
  // 'publicPath': '../fonts', // Указываем путь к шрифтам в HTML
};
