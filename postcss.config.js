/**
 * PostCSS for @wordpress/scripts (admin bundle).
 * Tailwind runs on imported CSS; SCSS is compiled by sass-loader first, then PostCSS.
 */
module.exports = {
	plugins: [
		require('tailwindcss'),
		require('autoprefixer')({
			grid: true,
		}),
	],
};
