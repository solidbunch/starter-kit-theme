'use strict';

module.exports = {
	theme: {
		prefix: 'ttt', // ffblank
		singleton: 'TTT', // FFBLANK
		textdomain: 'tttextdomain',  // fruitfulblanktextdomain
		name: 'Test Task Theme', // Fruitful Blank Theme
		author: 'unbirth' // Fruitful Code
	},
	dev: {
		browserSync: {
			proxyURL: 'design.loc', // yourlocaldomain,
			bypassPort: '8181'
		},
		/*
		browserslist: [ // See https://github.com/browserslist/browserslist
			'> 1%',
			'last 2 versions'
		],
		*/

		debug: {
			styles: true, // Render verbose CSS for debugging.
			scripts: true // Render verbose JS for debugging.
		}
	},
	export: {
		compress: true
	}
};

/*

usage:
======
TO REPLACE:
- change config
- run:
> npm i npm -g
> npm i gulp -g
> npm i
> gulp replaceNames

SASS + BROWSERSYNC:
> gulp sass - sass only compiling
> gulp watch - sass + browsersync
> gulp - default: gulp watch

*/