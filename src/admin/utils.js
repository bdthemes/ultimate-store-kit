import { __ } from '@wordpress/i18n';
import { applyFilters } from '@wordpress/hooks';

/**
 * Whether a widget counts as enabled in the admin (saved "on" plus Pro license
 * and required plugin active — same rules as the widget cards).
 *
 * @param {object} widget      Widget definition from PHP (may include dependency).
 * @param {string|undefined} savedValue Value from settings for this widget key.
 * @param {boolean} isPro      Licensed Pro user.
 * @returns {boolean}
 */
export const isWidgetEffectivelyOn = (widget, savedValue, isPro) => {
	if (widget.widget_type === 'pro' && !isPro) {
		return false;
	}
	const dep = widget.dependency;
	if (dep && (!dep.isInstalled || !dep.isActive)) {
		return false;
	}
	if (savedValue !== undefined && savedValue !== null) {
		return savedValue === 'on';
	}
	return widget.default === 'on';
};

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
	{
		id: 'sales-notification',
		label: __('Sales Notification', 'ultimate-store-kit'),
		description: __('Show recent purchases as a floating popup to build social proof.', 'ultimate-store-kit'),
		icon: 'sales-notification',
		badge: 'Pro',
		proPlaceholder: true,
	},
	{
		id: 'upsell-cross-sell',
		label: __('Upsell & Cross-Sell', 'ultimate-store-kit'),
		description: __('Display upsell and cross-sell products on product pages to increase sales.', 'ultimate-store-kit'),
		icon: 'upsell-cross-sell',
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
	if (haystack.includes('sales-notification') || haystack.includes('notification')) {
		return 'sales-notification';
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
	const placeholders = getPlaceholderModules();
	const placeholderIds = placeholders.map((p) => p.id);

	return sections.map((section) => {
		if (section.id === 'modules') {
			const dynamicItems = settingsGroups.map((group) => ({
				id: group.id,
				label: group.label,
				icon: getModuleSidebarIcon(group),
			}));

			if (isPro) {
				// Licensed: show real pro module items (injected via filters),
				// hide placeholder duplicates.
				return {
					...section,
					items: [...dynamicItems, ...section.items],
				};
			}

			// Not licensed: show placeholders, filter out any filter-injected
			// items whose IDs overlap with placeholders to avoid duplicates.
			const filtered = section.items.filter(
				(item) => !placeholderIds.includes(item.id)
			);
			return {
				...section,
				items: [...dynamicItems, ...placeholders, ...filtered],
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
