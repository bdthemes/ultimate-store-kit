/**
 * External Dependencies
 */
const { resolve } = require('path');
const webpack = require('webpack');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

const isProduction = process.env.NODE_ENV === 'production';

const newConfig = {
	...defaultConfig,
	...{
		entry: {
			admin: resolve(process.cwd(), 'src/adminx', 'index.js'),
		},
	},

	// Configure output for cache-proof chunk loading
	output: {
		...defaultConfig.output,
		// Use 'auto' to automatically determine publicPath from script location
		// This ensures chunks load from the correct plugin directory even when cached
		publicPath: 'auto',
		// Enhanced chunk naming for better debugging
		chunkFilename: '[name].js',
	},

	// Force React production build
	plugins: [
		...defaultConfig.plugins,
		// Explicitly define NODE_ENV as production to ensure React production build
		new webpack.DefinePlugin({
			'process.env.NODE_ENV': JSON.stringify(isProduction ? 'production' : 'development'),
		}),
	],

	// Display minimum info in terminal.
	stats: 'minimal',
};

// Development only.
if (!isProduction) {
	newConfig.devServer = {
		...newConfig.devServer,
		// Support for dev server on all domains.
		allowedHosts: 'all',
	};
}

module.exports = newConfig;