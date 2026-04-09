import { __ } from '@wordpress/i18n';
import { applyFilters } from '@wordpress/hooks';

const defaultPlaceholders = [
	{
		id: 'currency-switcher',
		label: __('Currency Switcher', 'ultimate-store-kit'),
		description: __('Enable to allow currency switching on your store.', 'ultimate-store-kit'),
		icon: 'currency-switcher',
		badge: 'Pro',
		proPlaceholder: true,
	},
	{
		id: 'variation-swatches',
		label: __('Variation Swatches', 'ultimate-store-kit'),
		description: __('Enable to display product variation swatches on your store.', 'ultimate-store-kit'),
		icon: 'variation-swatches',
		badge: 'Pro',
		proPlaceholder: true,
	},
	{
		id: 'live-visitor-count',
		label: __('Live Visitor Count', 'ultimate-store-kit'),
		description: __('Display live visitor count on product pages to create urgency.', 'ultimate-store-kit'),
		icon: 'live-visitor-count',
		badge: 'Pro',
		proPlaceholder: true,
	},
];

const getPlaceholderModules = () =>
	applyFilters('usk.admin.placeholderModules', defaultPlaceholders);

const navItems = [
	{
		id: 'dashboard',
		group: __('Dashboard', 'ultimate-store-kit'),
		items: [
			{
				id: 'welcome',
				label: __('Welcome', 'ultimate-store-kit'),
				icon: 'home',
			},
		],
	},
	{
		id: 'widgets',
		group: __('Widgets', 'ultimate-store-kit'),
		items: [
			{
				id: 'woocommerce-widgets',
				label: __('WooCommerce', 'ultimate-store-kit'),
				icon: 'woocommerce',
			},
			{
				id: 'edd-widgets',
				label: __('EDD', 'ultimate-store-kit'),
				icon: 'edd',
			},
			{
				id: 'other-widgets',
				label: __('Others', 'ultimate-store-kit'),
				icon: 'other',
			},
		],
	},
	{
		id: 'modules',
		group: __('Modules', 'ultimate-store-kit'),
		items: [],
	},
	{
		id: 'support',
		group: __('Support', 'ultimate-store-kit'),
		items: [
			{
				id: 'get-pro',
				label: __('Get Pro', 'ultimate-store-kit'),
				icon: 'star',
			},
			{
				id: 'about',
				label: __('About & Info', 'ultimate-store-kit'),
				icon: 'info',
			},
		],
	},
];

const groupHeadingClass =
	'mb-3 px-2 text-xs font-semibold uppercase tracking-widest text-gray-400';

const getModuleSidebarIcon = (group) => {
	const id = (group.id || '').toLowerCase();
	const label = (group.label || '').toLowerCase();
	const haystack = `${id} ${label}`;
	if (haystack.includes('currency')) {
		return 'currency-switcher';
	}
	if (haystack.includes('swatch') || haystack.includes('variation')) {
		return 'variation-swatches';
	}
	if (haystack.includes('visitor') || haystack.includes('live')) {
		return 'live-visitor-count';
	}
	return 'grid';
};

const getAdminBarHeight = () =>
	document.getElementById('wpadminbar')?.offsetHeight || 0;

const getNavItems = () => applyFilters('usk.admin.navItems', navItems);

const buildSidebarSections = ({
	isPro,
	settingsGroups = [],
}) => {
	const sections = getNavItems();
	const placeholders = isPro ? [] : getPlaceholderModules();

	return sections.map((section) => {
		if (section.id === 'modules') {
			const dynamicItems = settingsGroups.map((group) => ({
				id: group.id,
				label: group.label,
				icon: getModuleSidebarIcon(group),
			}));
			return {
				...section,
				items: [...dynamicItems, ...placeholders, ...section.items],
			};
		}
		return section;
	});
};

export {
	buildSidebarSections,
	getAdminBarHeight,
	getModuleSidebarIcon,
	getNavItems,
	getPlaceholderModules,
	groupHeadingClass,
	navItems,
};
