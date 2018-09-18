var gulp = require('gulp');
var gulpSass = require('gulp-sass');
var gulpSourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync');
var gulpAutoprefixer = require('gulp-autoprefixer');
var tabify = require('gulp-tabify');
var stringReplace = require('gulp-string-replace');


var config = require('./themeConfig.js');

// Project paths
var paths = {

	toReplace : {
		src: ['./**/*.php', './**/*.css', './**/*.scss', './**/*.js', '!vendor/**/*.*', '!node_modules/**/*.*', '!./themeConfig.js', '!./gulpfile.js'],
	},

	php: {
		src: ['./**/*.php', '!vendor/**/*.*', '!node_modules/**/*.*'],
		//dest: './'
	},
	css: {
		src: ['core/**/*.css', 'assets/**/*.css'],
		//dest: './'
	},
	scss: {
		src: ['core/**/*.scss', 'assets/**/*.scss'],
		//dest: '.'
	},
	js: {
		src_all: ['core/**/*.js', 'assets/**/*.js'],
		src: ['core/**/*.js', 'assets/**/*.js', '!core/**/*.min.js', '!assets/**/*.min.js'],
		src_min: ['core/**/*.min.js', 'assets/**/*.min.js'],
		//dest: './'
	},
	images: {
		src: ['assets/images/**/*.{jpg,JPG,png,PNG,svg,SVG}'],
		//dest: './'
	},
	export: {
		src: ['**/*', '!node_modules', '!node_modules/**/*', '!composer.*', '!gulpfile.*', '!package*.*', '!phpcs.*', '!*.zip'],
		dest: './'
	}
};


gulp.task('sass',  function () {

	return gulp.src(paths.scss.src)
		.pipe(gulpSourcemaps.init())
		.pipe(gulpSass({outputStyle: 'expanded'}).on('error', gulpSass.logError)) // nested - default; expanded ; compact ; compressed
		.pipe(gulpAutoprefixer(['last 5 versions', '> 1%', 'ie 11'], {cascade: true}))
		.pipe(tabify(2, true))
		.pipe(gulpSourcemaps.write('.'))  // THE SAME DIR
		.pipe(gulp.dest(function(file){
			return file.base;  // THE SAME DIR
		}))
		.pipe(browserSync.reload({stream: true}));
});


gulp.task('browserSyncRun', function () {
	browserSync({
		proxy: {
			target: config.dev.browserSync.proxyURL, // your localhost url
		},
		//https: true,
		port: config.dev.browserSync.bypassPort,
		liveReload: true,
		reloadOnRestart: true,
		open: "local",
		notify: false
	});
});


gulp.task('replaceNames', function () {

	return gulp.src(paths.toReplace.src)
		.pipe(stringReplace('ffblank', config.theme.prefix))
		.pipe(stringReplace('FFBLANK', config.theme.singleton))
		.pipe(stringReplace('fruitfulblanktextdomain', config.theme.textdomain))
		.pipe(stringReplace('Fruitful Blank Theme', config.theme.name))
		.pipe(stringReplace('Fruitful Code', config.theme.author))
		.pipe(gulp.dest(function(file){
			return file.base;  // THE SAME DIR
		}));
});






gulp.task('watch', ['sass','browserSyncRun'], function () {
	gulp.watch(paths.scss.src, ['sass'] );
	//gulp.watch('./**/*.php', browserSync.reload);
	//gulp.watch('./js/**/*.js', browserSync.reload);
});


gulp.task('default', ['watch']);
