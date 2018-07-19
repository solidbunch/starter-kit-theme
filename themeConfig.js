'use strict';

module.exports = {
	theme: {
		prefix: 'ffblank', // ffblank
		singleton: 'FFBLANK', // FFBLANK
		textdomain: 'fruitfulblanktextdomain',  // fruitfulblanktextdomain
		name: 'Fruitful Blank Theme', // Fruitful Blank Theme
		author: 'Fruitful Code' // Fruitful Code
	},
	dev: {
		browserSync: {
			proxyURL: 'blank.nul', // yourlocaldomain,
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