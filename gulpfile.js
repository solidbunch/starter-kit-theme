var gulp = require('gulp');
var stringReplace = require('gulp-string-replace');
var config = {
    theme: {
        prefix: 'ffblank', // ffblank
        singleton: 'FFBLANK', // FFBLANK
        textdomain: 'fruitfulblanktextdomain',  // fruitfulblanktextdomain
        name: 'Fruitful Blank Theme', // Fruitful Blank Theme
        author: 'Fruitful Code' // Fruitful Code
    }
};

// Project paths
var paths = {
    toReplace: {
        src: ['./**/*.php', './**/*.css', './**/*.scss', './**/*.js', '!vendor/**/*.*', '!node_modules/**/*.*', '!./themeConfig.js', '!./gulpfile.js'],
    },
};


gulp.task('replaceNames', function () {

    return gulp.src(paths.toReplace.src)
        .pipe(stringReplace('ffblank', config.theme.prefix))
        .pipe(stringReplace('FFBLANK', config.theme.singleton))
        .pipe(stringReplace('fruitfulblanktextdomain', config.theme.textdomain))
        .pipe(stringReplace('Fruitful Blank Theme', config.theme.name))
        .pipe(stringReplace('Fruitful Code', config.theme.author))
        .pipe(gulp.dest(function (file) {
            return file.base;  // THE SAME DIR
        }));
});
