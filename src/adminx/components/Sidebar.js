import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

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
				id: 'widgets',
				label: __('Widgets', 'ultimate-store-kit'),
				icon: 'grid',
			},
		],
	},
	{
		group: __('Settings', 'ultimate-store-kit'),
		items: [
			{
				id: 'other-settings',
				label: __('Other Settings', 'ultimate-store-kit'),
				icon: 'settings',
			},
			{
				id: 'license',
				label: __('License', 'ultimate-store-kit'),
				icon: 'badge',
			},
		],
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
				id: 'about',
				label: __('About & Info', 'ultimate-store-kit'),
				icon: 'info',
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

const Sidebar = ({ activePage, onNavigate, isPro }) => {
	const [showComingSoon, setShowComingSoon] = useState(true);

	return (
		<div className="sticky top-[7.5rem] z-[90] flex w-64 shrink-0 flex-col self-stretch justify-between border border-solid border-gray-100 bg-white px-4 py-6 rounded-lg">
			<nav className="flex flex-col gap-6" aria-label="Main">
				{navItems.map((section) => (
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
											onClick={() =>
												(() => {
													onNavigate(item.id);
													// Keep URL hash in sync so reload/direct links work.
													window.location.hash = `#${item.id}`;
												})()
											}
											className={`flex items-center w-full cursor-pointer gap-3 rounded-lg border-0 px-3 py-3 text-left text-sm font-medium transition-colors ${isActive
												? 'bg-[linear-gradient(313deg,#E62A3F_0%,#00216A_100%)] text-white shadow-sm'
												: 'bg-transparent text-slate-700 hover:bg-gray-100 hover:text-slate-900'
												}`}
										>
											<Icon name={item.icon} />
											{item.label}
										</button>
									</li>
								);
							})}
						</ul>
					</div>
				))}
			</nav>
			{showComingSoon && (
				<div className="mt-8 rounded-xl bg-slate-100 p-4">
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
		</div>
	);
};

export default Sidebar;
