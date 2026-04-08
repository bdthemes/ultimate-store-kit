import { useState } from '@wordpress/element';
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

/** Pick a sidebar icon for dynamic “Other settings” module groups */
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

const navItems = [
  {
    group: __("Dashboard", "ultimate-store-kit"),
    items: [
      {
        id: "welcome",
        label: __("Welcome", "ultimate-store-kit"),
        icon: "home",
      },
    ],
  },
  {
    group: __("Widgets", "ultimate-store-kit"),
    items: [
      {
        id: "woocommerce-widgets",
        label: __("WooCommerce", "ultimate-store-kit"),
        icon: "woocommerce",
      },
      {
        id: "edd-widgets",
        label: __("EDD", "ultimate-store-kit"),
        icon: "edd",
      },
      {
        id: "other-widgets",
        label: __("Others", "ultimate-store-kit"),
        icon: "other",
      },
    ],
  },
  {
    group: __("Modules", "ultimate-store-kit"),
    items: [],
  },
  {
    group: __("Support", "ultimate-store-kit"),
    items: [
      {
        id: "get-pro",
        label: __("Get Pro", "ultimate-store-kit"),
        icon: "star",
      },
      {
      	id: 'license',
      	label: __('License', 'ultimate-store-kit'),
      	icon: 'badge',
      },
      {
        id: "about",
        label: __("About & Info", "ultimate-store-kit"),
        icon: "info",
      },
    ],
  },
];

const groupHeadingClass =
	'mb-3 px-2 text-xs font-semibold uppercase tracking-widest text-gray-400';

const Icon = ({ name }) => {
	const common = 'h-5 w-5 block color-current';
	switch (name) {
		case 'home':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
					<path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
				</svg>

			);
		case 'grid':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<rect width={7} height={9} x={3} y={3} rx={1} />
					<rect width={7} height={5} x={14} y={3} rx={1} />
					<rect width={7} height={9} x={14} y={12} rx={1} />
					<rect width={7} height={5} x={3} y={16} rx={1} />
				</svg>

			);
		case 'currency-switcher':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<circle cx="12" cy="12" r="10" />
					<path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
					<path d="M12 18V6" />
				</svg>
			);
		case 'variation-swatches':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
					<circle cx="7.5" cy="10.5" r=".5" fill="currentColor" stroke="none" />
					<circle cx="12" cy="7.5" r=".5" fill="currentColor" stroke="none" />
					<circle cx="16.5" cy="10.5" r=".5" fill="currentColor" stroke="none" />
					<circle cx="9" cy="15.5" r=".5" fill="currentColor" stroke="none" />
				</svg>
			);
		case 'settings':
			return (
				<svg

					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
					<circle cx={12} cy={12} r={3} />
				</svg>

			);
		case 'badge':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z" />
					<circle cx="16.5" cy="7.5" r=".5" fill="currentColor" />
				</svg>

			);
		case 'star':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
				</svg>

			);
		case 'woocommerce':
			return (
				<svg
				xmlns="http://www.w3.org/2000/svg"
				width={24}
				height={24}
				viewBox="0 0 24 24"
				fill="none"
				stroke="currentColor"
				strokeWidth={2}
				strokeLinecap="round"
				strokeLinejoin="round"
				className={common}
				>
				<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5" />
				<path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244" />
				<path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05" />
				</svg>
			);
		case 'edd':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
					<path d="m7.5 4.21 4.5 2.6 4.5-2.6" />
					<path d="M12 17.5V12" />
				</svg>
			);
		case 'other':
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<rect width={7} height={9} x={3} y={3} rx={1} />
					<rect width={7} height={5} x={14} y={3} rx={1} />
					<rect width={7} height={9} x={14} y={12} rx={1} />
					<rect width={7} height={5} x={3} y={16} rx={1} />
				</svg>
			);
		case 'info':
		default:
			return (
				<svg
					xmlns="http://www.w3.org/2000/svg"
					width={24}
					height={24}
					viewBox="0 0 24 24"
					fill="none"
					stroke="currentColor"
					strokeWidth={2}
					strokeLinecap="round"
					strokeLinejoin="round"
					className={common}
				>
					<circle cx={12} cy={12} r={10} />
					<path d="M12 16v-4" />
					<path d="M12 8h.01" />
				</svg>

			);
	}
};

const getAdminBarHeight = () =>
	document.getElementById('wpadminbar')?.offsetHeight || 0;

const Sidebar = ({ activePage, onNavigate, isPro, isProPluginActive, isOpen, isDesktop, onClose, settingsGroups = [] }) => {
	const [showComingSoon, setShowComingSoon] = useState(true);

	const buildSections = () => {
		return navItems.map((section) => {
			if (section.group === __('Modules', 'ultimate-store-kit')) {
				const dynamicItems = settingsGroups.map((g) => ({
					id: g.id,
					label: g.label,
					icon: getModuleSidebarIcon(g),
				}));
				// Keep module links visible when Pro is installed but the license is inactive.
				// The Pro plugin can still render its admin pages from the hash route.
				const placeholders = isPro ? [] : proModulePlaceholders;
				return { ...section, items: [...dynamicItems, ...placeholders, ...section.items] };
			}
			return section;
		});
	};

	const content = (
		<>
			<nav className="flex flex-col gap-6" aria-label="Main">
				{buildSections().map((section) => (
					<div key={section.group}>
						<p className={`m-0 ${groupHeadingClass}`}>
							{section.group}
						</p>
						<ul className="m-0 list-none space-y-1 p-0">
							{section.items
								.filter((item) => !(isPro && item.id === 'get-pro'))
								.map((item) => {
									const isActive = activePage === item.id;
									return (
										<li key={item.id}>
											<button
												type="button"
												onClick={() => {
													onNavigate(item.id);
													window.location.hash = `#${item.id}`;
													onClose();
												}}
												className={`flex w-full cursor-pointer items-center gap-3 rounded-lg border-0 px-3 py-3 text-left text-sm font-medium transition-colors ${
													isActive
														? 'bg-uks-brand text-white shadow-sm'
														: 'bg-transparent text-slate-700 hover:bg-gray-100 hover:text-slate-900'
												}`}
											>
												<Icon name={item.icon} />
												<span className="flex-1">{item.label}</span>
												{item.badge && (
													<span
														className="shrink-0 whitespace-nowrap rounded-md border border-solid px-1.5 py-0.5 text-[9px] font-bold"
														style={{
															borderColor: isActive
																? 'rgba(255,255,255,0.4)'
																: '#e5e7eb',
															color: isActive ? '#fff' : '#6b7280',
															background: isActive
																? 'rgba(255,255,255,0.18)'
																: 'transparent',
														}}
													>
														{item.badge}
													</span>
												)}
											</button>
										</li>
									);
								})}
						</ul>
					</div>
				))}
			</nav>
			{showComingSoon && (
				<div className="mt-6 hidden rounded-xl bg-slate-100 p-4 lg:block lg:mt-8">
					<div className="relative ">
						<button
							type="button"
							onClick={() => setShowComingSoon(false)}
							className="absolute right-1 top-1 inline-flex cursor-pointer items-center justify-center border-0 bg-transparent text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600"
							aria-label={__('Close', 'ultimate-store-kit')}
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width={24}
								height={24}
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth={2}
								strokeLinecap="round"
								strokeLinejoin="round"
								className="w-4 h-4 block"
							>
								<path d="M18 6 6 18" />
								<path d="m6 6 12 12" />
							</svg>

						</button>
						<span className="mb-2.5 text-base font-bold text-slate-800 flex items-center gap-2">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width={24}
								height={24}
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth={2}
								strokeLinecap="round"
								strokeLinejoin="round"
								className="w-5 h-5"
							>
								<path d="M12 2v4" />
								<path d="m16.2 7.8 2.9-2.9" />
								<path d="M18 12h4" />
								<path d="m16.2 16.2 2.9 2.9" />
								<path d="M12 18v4" />
								<path d="m4.9 19.1 2.9-2.9" />
								<path d="M2 12h4" />
								<path d="m4.9 4.9 2.9 2.9" />
							</svg>
							{__('Coming soon', 'ultimate-store-kit')}
						</span>
						<p className="m-0 text-[12px] leading-relaxed text-slate-600">
							{__(
								'New items planned for upcoming updates:',
								'ultimate-store-kit'
							)}
						</p>
						<ul className="mt-2.5 m-0 space-y-1.5 p-0 text-[12px] text-slate-600">
							<li className="flex items-start gap-2">
								<span className="mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand" />
								{__('7+ WooCommerce widgets', 'ultimate-store-kit')}
							</li>
							<li className="flex items-start gap-2">
								<span className="mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand" />
								{__('Template-based presets', 'ultimate-store-kit')}
							</li>
							<li className="flex items-start gap-2">
								<span className="mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand" />
								{__('Performance-focused improvements', 'ultimate-store-kit')}
							</li>
						</ul>
						<button
							onClick={() =>
								window.open(
									'https://feedback.bdthemes.com/b/6vr2250l/feature-requests',
									'_blank'
								)
							}
							type="button"
							className="mt-3 inline-flex cursor-pointer items-center rounded-lg border border-uks-brand bg-white px-3 py-1.5 text-[12px] font-semibold text-uks-brand transition-colors hover:bg-uks-brand hover:text-white"
						>
							{__('See roadmap', 'ultimate-store-kit')}
						</button>
					</div>
				</div>
			)}
		</>
	);

	if (isDesktop) {
		return (
			<div style={{ display: 'flex' }} className="w-64 shrink-0 flex-col justify-between self-stretch rounded-lg border border-solid border-gray-100 bg-white px-4 py-6 lg:sticky lg:top-[7.5rem]">
				{content}
			</div>
		);
	}

	const adminBarH = getAdminBarHeight();

	return (
		<>
			{isOpen && (
				<div
					style={{
						display: 'block',
						position: 'fixed',
						top: adminBarH,
						left: 0,
						right: 0,
						bottom: 0,
						zIndex: 99998,
						backgroundColor: 'rgba(0,0,0,0.3)',
					}}
					onClick={onClose}
					aria-hidden="true"
				/>
			)}
			<div
				style={{
					position: 'fixed',
					left: 0,
					top: adminBarH,
					zIndex: 99999,
					height: `calc(100vh - ${adminBarH}px)`,
					width: '86vw',
					maxWidth: '320px',
					display: 'flex',
					flexDirection: 'column',
					backgroundColor: '#fff',
					padding: '1rem',
					boxShadow: '4px 0 24px rgba(0,0,0,0.15)',
					transform: isOpen ? 'translateX(0)' : 'translateX(-100%)',
					transition: 'transform 300ms ease-out',
					pointerEvents: isOpen ? 'auto' : 'none',
					overflowY: 'auto',
				}}
			>
				<div className="mb-3 flex items-center justify-between">
					<p className="m-0 text-sm font-bold text-slate-700">
						{__('Navigation', 'ultimate-store-kit')}
					</p>
					<button
						type="button"
						onClick={onClose}
						className="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-md border border-slate-200 bg-white text-slate-500 hover:text-slate-700"
						aria-label={__('Close menu', 'ultimate-store-kit')}
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							strokeWidth={2}
							strokeLinecap="round"
							strokeLinejoin="round"
							className="h-4 w-4"
						>
							<path d="M18 6 6 18" />
							<path d="m6 6 12 12" />
						</svg>
					</button>
				</div>
				{content}
			</div>
		</>
	);
};

export default Sidebar;
