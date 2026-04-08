/**
 * External Dependencies
 */
const fs = require('fs');
const { resolve, relative, extname, join } = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const defaultConfig = require('@wordpress/scripts/config/webpack.config');

const isProduction = process.env.NODE_ENV === 'production';

/**
 * Recursively find files by extension, skipping SCSS partials (prefixed with _).
 */
function findFiles(dir, ext) {
	const results = [];
	if (!fs.existsSync(dir)) return results;
	const items = fs.readdirSync(dir, { withFileTypes: true });
	for (const item of items) {
		const fullPath = join(dir, item.name);
		if (item.isDirectory()) {
			// Skip src/scss/components folder
			if (fullPath.includes('src/scss/components')) continue;
			results.push(...findFiles(fullPath, ext));
		} else if (item.name.endsWith(ext) && !item.name.startsWith('_')) {
			results.push(fullPath);
		}
	}
	return results;
}

// Build entry map: srcDir -> outDir (without extension)
function buildEntries(srcDir, ext, outDir) {
	const entries = {};
	findFiles(resolve(__dirname, srcDir), ext).forEach((file) => {
		const rel = relative(resolve(__dirname, srcDir), file);
		const name = rel.replace(extname(rel), '');
		entries[`${outDir}/${name}`] = file;
	});
	return entries;
}

// src/js/**/*.js -> assets/js/**/*.js
const jsEntries = buildEntries('src/js', '.js', 'js');

// src/scss/**/*.scss -> assets/css/**/*.css (partials excluded)
const scssEntries = buildEntries('src/scss', '.scss', 'css');

// src/admin/dashboard.js -> assets/admin/admin.js (+ admin.css via style.scss import)
const adminEntries = {
	'admin/admin': resolve(__dirname, 'src/admin/dashboard.js'),
};

// src/admin/others/**/*.js -> assets/admin/others/**/*.js
const adminOthersJsEntries = buildEntries('src/admin/others', '.js', 'admin/others');

// src/admin/others/scss/**/*.scss -> assets/admin/others/css/**/*.css
const adminOthersScssEntries = (() => {
	const entries = {};
	const base = resolve(__dirname, 'src/admin/others');
	findFiles(base, '.scss').forEach((file) => {
		const rel = relative(base, file);
		const name = rel.replace(extname(rel), '').replace(/^scss([\\/])/, 'css$1');
		entries[`admin/others/${name}`] = file;
	});
	return entries;
})();

// Keep default plugins except MiniCssExtractPlugin and CopyPlugin (we define our own)
const filteredPlugins = defaultConfig.plugins.filter(
	(plugin) =>
		!(plugin instanceof MiniCssExtractPlugin) &&
		!(plugin.constructor && plugin.constructor.name === 'CopyPlugin')
);

// Remove the default SCSS rule — we supply our own with url resolution disabled
const defaultScssRule = (defaultConfig.module?.rules || []).find(
	(rule) => rule && rule.test && rule.test.toString() === /\.(sc|sa)ss$/.toString()
);
const nonScssRules = (defaultConfig.module?.rules || []).filter((r) => r !== defaultScssRule);

// Clone the default SCSS rule but set url:false on css-loader
const scssRule = {
	...defaultScssRule,
	use: defaultScssRule.use.map((u) => {
		const loader = typeof u === 'string' ? u : u?.loader;
		if (loader && /[\\/]css-loader[\\/]/.test(loader)) {
			return {
				...(typeof u === 'string' ? { loader: u } : u),
				options: { ...(typeof u === 'object' ? u.options : {}), url: false },
			};
		}
		return u;
	}),
};

const config = {
	...defaultConfig,

	entry: {
		...jsEntries,
		...scssEntries,
		...adminEntries,
		...adminOthersJsEntries,
		...adminOthersScssEntries,
	},

	output: {
		path: resolve(__dirname, 'assets'),
		filename: '[name].js',
		publicPath: 'auto',
		chunkFilename: '[name].js',
	},

	module: {
		...defaultConfig.module,
		rules: [...nonScssRules, scssRule],
	},

	plugins: [
		new RemoveEmptyScriptsPlugin(),
		new MiniCssExtractPlugin({ filename: '[name].css' }),
		new CopyWebpackPlugin({
			patterns: [
				{ from: 'src/fonts', to: 'fonts' },
				{ from: 'src/images', to: 'images' },
				{ from: 'src/vendor', to: 'vendor' },
			],
		}),
		new webpack.DefinePlugin({
			'process.env.NODE_ENV': JSON.stringify(
				isProduction ? 'production' : 'development'
			),
		}),
		...filteredPlugins.filter(
			(p) => p.constructor.name !== 'DependencyExtractionWebpackPlugin'
		),

		/*
		 * Keep @wordpress/* externals but remove .asset.php files after build
		 */
		new (require('@wordpress/dependency-extraction-webpack-plugin'))(),
		{
			apply(compiler) {
				compiler.hooks.afterEmit.tapAsync('RemoveAssetPhp', (compilation, callback) => {
					const outputPath = compilation.outputOptions.path;
					findFiles(outputPath, '.asset.php').forEach((file) => {
						try { fs.unlinkSync(file); } catch (e) { /* ignore */ }
					});
					callback();
				});
			},
		},
	],

	devtool: false,
	stats: 'minimal',
};

if (!isProduction) {
	config.devServer = {
		...config.devServer,
		allowedHosts: 'all',
	};
}

module.exports = config;