/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./src/admin/**/*.{js,jsx}',
		'../ultimate-store-kit-pro/src/admin/**/*.{js,jsx}',
	],

	// Scope utilities under the WP admin mount node (see Dashboard.php). `important` as a
	// selector emits `.ultimate-store-kit-admin-root .w-full { … }` (descendant), NOT chained.
	// So width/height/flex utilities on the SAME element as `ultimate-store-kit-admin-root`
	// never match — put Tailwind classes only on descendants, or use a wrapper with
	// `display: contents` around portaled UI (see OfferEditor).
	important: '.ultimate-store-kit-admin-root',

	corePlugins: {
		preflight: false,
	},

	theme: {
		extend: {
			fontFamily: {
				sans: [
					'"IBM Plex Sans"',
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
					brand: '#E30C1D',
					'brand-dark': '#B80A17',
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
				// Element Pack dashboard radii.
				tile: '11px',
				panel: '16px',
				card: '18px',
			},
			boxShadow: {
				usk: '0 2px 8px rgba(0, 0, 0, 0.06)',
				pop: '0 24px 60px -16px rgba(0, 0, 0, 0.32)',
				glow: '0 6px 18px rgba(227, 12, 29, 0.28)',
				'glow-lg': '0 8px 24px rgba(227, 12, 29, 0.38)',
				lift: '0 12px 26px -14px rgba(0, 0, 0, 0.22)',
			},
			backgroundImage: {
				'gradient-brand': 'linear-gradient(135deg, #ff4f57, #E30C1D)',
			},
			keyframes: {
				uskPop: {
					from: { opacity: '0', transform: 'translateY(6px) scale(.98)' },
					to: { opacity: '1', transform: 'none' },
				},
				uskSlideIn: {
					from: { opacity: '0', transform: 'translateY(-8px)' },
					to: { opacity: '1', transform: 'translateY(0)' },
				},
				/** Offer editor drawer (slides in from right) */
				offerDrawerSlide: {
					from: { transform: 'translateX(100%)' },
					to: { transform: 'translateX(0)' },
				},
			},
			animation: {
				'usk-slide-in': 'uskSlideIn 0.3s ease',
				'usk-pop': 'uskPop .25s cubic-bezier(.16,1,.3,1) both',
				'offer-drawer': 'offerDrawerSlide 200ms ease-out',
			},
		},
	},

	plugins: [],

	// Pro admin JSX (../ultimate-store-kit-pro/...) is in `content`, but arbitrary utilities
	// are easy to miss after edits if the free admin CSS isn’t rebuilt — keep critical layout classes emitted.
	safelist: [
		'w-[400px]',
		'min-w-[400px]',
		'max-w-[400px]',
		'w-[min(1200px,100vw)]',
		'max-w-[min(1200px,100vw)]',
		'z-[159000]',
		'sm:grid-cols-2',
		'sm:grid-cols-3',
		'lg:grid-cols-2',
		'lg:grid-cols-3',
		'xl:grid-cols-2',
		'xl:grid-cols-4',
		'2xl:grid-cols-4',
	],
};
