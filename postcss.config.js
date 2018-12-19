module.exports = {
	options: {
		sourceMap: false,
		minimize: true
	},
	plugins: [
		require('autoprefixer'),
		require('cssnano')({
			preset: ['default', {discardComments: {removeAll: true}}],
			canPrint: true
		})
	]
};
