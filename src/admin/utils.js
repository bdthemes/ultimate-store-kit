import { __ } from '@wordpress/i18n';

const proModulePlaceholders = [
	{
		id: 'currency-switcher',
		label: __('Currency Switcher', 'ultimate-store-kit'),
		icon: 'currency-switcher',
		badge: 'Pro',
		proPlaceholder: true,
	},
	{
		id: 'variation-swatches',
		label: __('Variation Swatches', 'ultimate-store-kit'),
		icon: 'variation-swatches',
		badge: 'Pro',
		proPlaceholder: true,
	},
];

const navItems = [
	{
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
		group: __('Modules', 'ultimate-store-kit'),
		items: [],
	},
	{
		group: __('Support', 'ultimate-store-kit'),
		items: [
			{
				id: 'get-pro',
				label: __('Get Pro', 'ultimate-store-kit'),
				icon: 'star',
			},
			{
				id: 'license',
				label: __('License', 'ultimate-store-kit'),
				icon: 'badge',
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
	return 'grid';
};

const getAdminBarHeight = () =>
	document.getElementById('wpadminbar')?.offsetHeight || 0;

const buildSidebarSections = ({
	items,
	isPro,
	isProPluginActive,
	settingsGroups = [],
}) =>
	items.map((section) => {
		if (section.group === __('Modules', 'ultimate-store-kit')) {
			const dynamicItems = settingsGroups.map((group) => ({
				id: group.id,
				label: group.label,
				icon: getModuleSidebarIcon(group),
			}));
			const placeholders =
				isPro || isProPluginActive ? [] : proModulePlaceholders;
			return {
				...section,
				items: [...dynamicItems, ...placeholders, ...section.items],
			};
		}
		return section;
	});

export {
	buildSidebarSections,
	getAdminBarHeight,
	getModuleSidebarIcon,
	groupHeadingClass,
	navItems,
	proModulePlaceholders,
};
