/**
 * External Dependencies
 */
const { resolve } = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

const isProduction = process.env.NODE_ENV === 'production';

const pluginsWithAdminCssName = defaultConfig.plugins.map((plugin) => {
	if (plugin instanceof MiniCssExtractPlugin) {
		// Single entry `admin` — fixed name matches includes/Admin/Menu.php (avoid style-[name] resolving to ./style-admin paths).
		return new MiniCssExtractPlugin({
			filename: 'style-admin.css',
		});
	}
	return plugin;
});

const newConfig = {
	...defaultConfig,
	...{
		entry: {
			admin: resolve(process.cwd(), 'src/admin', 'dashboard.js'),
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

	// Force React production build; keep CSS filename as style-admin.css (see includes/Admin/Menu.php)
	plugins: [
		...pluginsWithAdminCssName,
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