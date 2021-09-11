var gulp = require('gulp');
var stringReplace = require('gulp-string-replace');
var config = {
	theme: {
        name: 'Starter Kit Theme',	// Change theme name
		prefix: 'StarterKit',		// Change theme prefix
		singleton: 'Starter_Kit',	// Change theme main class
		textdomain: 'starter-kit',	// Change textdomain
		styles: 'starter-kit',		// Change CSS styles prefix
		author: 'SolidBunch',		// Change author
		theme_uri: 'https://github.com/SolidBunch/Starter-Kit', 	// Change theme URI
		author_uri: 'https://solidbunch.com',	// Change author URI
	}
};

// Project paths
var paths = {
	
	toReplace: {
		src: ['./**/*.php', './**/*.css', './**/*.scss', './**/*.js', '!vendor/**/*.*','!vendor-custom/**/*.*', '!node_modules/**/*.*', '!./gulpfile.js'],
	},
};

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
