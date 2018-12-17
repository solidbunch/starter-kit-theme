var gulp = require('gulp');
var stringReplace = require('gulp-string-replace');
var config = {
	theme: {
        name: 'Starter Kit Theme',	// Change theme name
		prefix: 'StarterKit',		// Change theme prefix
		singleton: 'Starter_Kit',	// Change theme main class
		textdomain: 'starter-kit',	// Change textdomain
		styles: 'starter-kit',		// Change CSS styles refix
		author: 'SolidBunch',		// Change author
		theme_uri: 'https://github.com/SolidBunch/Starter-Kit', 	// Change theme URI
		author_uri: 'https://solidbunch.com',	// Change author URI
	}
	/*
	,
	dev: {
		browserSync: {
			proxyURL: 'starter-kit.loc', // yourlocaldomain,
			bypassPort: '8181'
		},
		/*
		browserslist: [ // See https://github.com/browserslist/browserslist
			'> 1%',
			'last 2 versions'
		],
		*-/

		debug: {
			styles: true, // Render verbose CSS for debugging.
			scripts: true // Render verbose JS for debugging.
		}
	},
	export: {
		compress: true
	} */
};

var gulpSass = require('gulp-sass');
var gulpSourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync');
var gulpAutoprefixer = require('gulp-autoprefixer');
var tabify = require('gulp-tabify');


// Project paths
var paths = {
	
	toReplace: {
		src: ['./**/*.php', './**/*.css', './**/*.scss', './**/*.js', '!vendor/**/*.*', '!node_modules/**/*.*', '!./themeConfig.js', '!./gulpfile.js'],
	},
	
	php: {
		src: ['./**/*.php', '!vendor/**/*.*', '!node_modules/**/*.*'],
		//dest: './'
	},
	css: {
		src: ['app/**/*.css', 'assets/**/*.css'],
		//dest: './'
	},
	scss: {
		src: ['app/**/*.scss', 'assets/**/*.scss'],
		//dest: '.'
	},
	js: {
		src_all: ['app/**/*.js', 'assets/**/*.js'],
		src: ['app/**/*.js', 'assets/**/*.js', '!app/**/*.min.js', '!assets/**/*.min.js'],
		src_min: ['app/**/*.min.js', 'assets/**/*.min.js'],
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


gulp.task('sass', function () {
	
	return gulp.src(paths.scss.src)
		.pipe(gulpSourcemaps.init())
		.pipe(gulpSass({outputStyle: 'expanded'}).on('error', gulpSass.logError)) // nested - default; expanded ; compact ; compressed
		.pipe(gulpAutoprefixer(['last 5 versions', '> 1%', 'ie 11'], {cascade: true}))
		.pipe(tabify(2, true))
		.pipe(gulpSourcemaps.write('.'))  // THE SAME DIR
		.pipe(gulp.dest(function (file) {
			return file.base;  // THE SAME DIR
		}))
		.pipe(browserSync.reload({stream: true}));
});

//
// gulp.task('browserSyncRun', function () {
// 	browserSync({
// 		proxy: {
// 			target: config.dev.browserSync.proxyURL, // your localhost url
// 		},
// 		//https: true,
// 		port: config.dev.browserSync.bypassPort,
// 		liveReload: true,
// 		reloadOnRestart: true,
// 		open: "local",
// 		notify: false
// 	});
// });


gulp.task('watch', ['sass'], function () {
	gulp.watch(paths.scss.src, ['sass']);
	//gulp.watch('./**/*.php', browserSync.reload);
	//gulp.watch('./js/**/*.js', browserSync.reload);
});


gulp.task('default', ['watch']);


gulp.task('replaceNames', function () {
	
	return gulp.src(paths.toReplace.src)
		.pipe(stringReplace('StarterKit', config.theme.prefix))
		.pipe(stringReplace('Starter_Kit', config.theme.singleton))
		
		// Styles, classes, ID
		.pipe(stringReplace('class="starter-kit-', 'class = "' + config.theme.styles + '-'))
		.pipe(stringReplace('class = "starter-kit-', 'class = "' + config.theme.styles + '-'))
		.pipe(stringReplace('class="starter-kit_', 'class = "' + config.theme.styles + '_'))
		.pipe(stringReplace('class = "starter-kit_', 'class = "' + config.theme.styles + '_'))
		.pipe(stringReplace('#starter-kit-', '#' + config.theme.styles + '-'))
		.pipe(stringReplace('id="starter-kit-', 'id = "' + config.theme.styles + '-'))
		.pipe(stringReplace('id = "starter-kit-', 'id = "' + config.theme.styles + '-'))
		.pipe(stringReplace('\'starter-kit_', '\'' + config.theme.styles + '_'))
		.pipe(stringReplace('\\.starter-kit-', '.' + config.theme.styles + '-'))
		.pipe(stringReplace('\\.starter-kit_', '.' + config.theme.styles + '_'))
		
		// Textdomain
		.pipe(stringReplace('Text Domain: starter-kit', 'Text Domain: ' + config.theme.textdomain))
		.pipe(stringReplace('\'starter-kit', '\'' + config.theme.textdomain))
		.pipe(stringReplace('\"starter-kit', '"' + config.theme.textdomain))
		
		.pipe(stringReplace('Starter Kit Theme', config.theme.name))
		
		.pipe(stringReplace('SolidBunch', config.theme.author))
		.pipe(stringReplace('https://github.com/SolidBunch/Starter-Kit', config.theme.theme_uri))
		.pipe(stringReplace('https://solidbunch.com', config.theme.author_uri))
		
		.pipe(gulp.dest(function (file) {
			return file.base;  // THE SAME DIR
		}));
});
