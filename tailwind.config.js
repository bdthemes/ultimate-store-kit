/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ['./src/admin/**/*.{js,jsx}'],

	// Scope utilities under the WP admin mount node (see Menu.php). Do NOT use the same
	// class as the element that also carries Tailwind utilities — important: '.foo' emits
	// `.foo .utility` (descendant), so utilities on `.foo` itself would never match.
	important: '.ultimate-store-kit-admin-root',

	corePlugins: {
		preflight: false,
	},

	theme: {
		extend: {
			fontFamily: {
				sans: [
					'-apple-system',
					'BlinkMacSystemFont',
					'"Segoe UI"',
					'Roboto',
					'Oxygen',
					'Ubuntu',
					'sans-serif',
				],
			},
			colors: {
				uks: {
					brand: '#00216A',
					'brand-dark': '#00216A',
					dark: '#1a2332',
					/** ~darken($dark, 3%) for sidebar promo */
					'dark-deep': '#161e2a',
					surface: '#f1f5f9',
					border: '#e2e8f0',
					muted: '#64748b',
				},
			},
			borderRadius: {
				usk: '10px',
			},
			boxShadow: {
				usk: '0 2px 8px rgba(0, 0, 0, 0.06)',
			},
			keyframes: {
				uskSlideIn: {
					from: { opacity: '0', transform: 'translateY(-8px)' },
					to: { opacity: '1', transform: 'translateY(0)' },
				},
			},
			animation: {
				'usk-slide-in': 'uskSlideIn 0.3s ease',
			},
		},
	},

	plugins: [],
};
