import { __ } from '@wordpress/i18n';

const navItems = [
	{
		group: __('Dashboard', 'ultimate-store-kit'),
		items: [
			{
				id: 'welcome',
				label: __('Welcome', 'ultimate-store-kit'),
				icon: 'dashicons-admin-home',
			},
		],
	},
	{
		group: __('Widgets', 'ultimate-store-kit'),
		items: [
			{
				id: 'widgets',
				label: __('Widgets', 'ultimate-store-kit'),
				icon: 'dashicons-admin-widgets',
			},
		],
	},
	{
		group: __('Settings', 'ultimate-store-kit'),
		items: [
			{
				id: 'other',
				label: __('Other Settings', 'ultimate-store-kit'),
				icon: 'dashicons-admin-settings',
			},
			{
				id: 'license',
				label: __('License', 'ultimate-store-kit'),
				icon: 'dashicons-admin-network',
			},
		],
	},
	{
		group: __('Support', 'ultimate-store-kit'),
		items: [
			{
				id: 'getpro',
				label: __('Get Pro', 'ultimate-store-kit'),
				icon: 'dashicons-star-filled',
			},
			{
				id: 'about',
				label: __('About & Info', 'ultimate-store-kit'),
				icon: 'dashicons-info',
			},
		],
	},
];

const groupHeadingClass =
	'mb-3 px-2 text-[11px] font-semibold uppercase tracking-widest text-gray-500';

const Sidebar = ({ activePage, onNavigate, isPro }) => {
	return (
		<div className="sticky top-[7.5rem] z-[90] flex w-64 shrink-0 flex-col self-stretch justify-between border border-solid border-gray-100 bg-white px-4 py-6 rounded-lg">
			<nav className="flex flex-col gap-6" aria-label="Main">
				{navItems.map((section) => (
					<div key={section.group}>
						<p className={`m-0 ${groupHeadingClass}`}>
							{section.group}
						</p>
						<ul className="m-0 list-none space-y-1 p-0">
							{section.items.map((item) => {
								const isActive = activePage === item.id;
								return (
									<li key={item.id}>
										<button
											type="button"
											onClick={() =>
												onNavigate(item.id)
											}
											className={`flex w-full cursor-pointer items-center gap-3 rounded-lg border-0 px-3 py-2.5 text-left text-[13px] font-medium transition-colors ${
												isActive
													? 'bg-blue-500 text-white shadow-sm'
													: 'bg-transparent text-slate-700 hover:bg-gray-100'
											}`}
										>
											<span
												className={`dashicons ${item.icon} shrink-0 text-lg ${
													isActive
														? 'text-white'
														: 'text-gray-400'
												}`}
												aria-hidden="true"
											/>
											{item.label}
										</button>
									</li>
								);
							})}
						</ul>
					</div>
				))}
			</nav>
			<div className="mt-8 px-2">
				{isPro ? (
					<div className="rounded-lg bg-emerald-500 px-3 py-2.5 text-center text-xs font-bold uppercase tracking-wide text-white shadow-sm">
						{__('Pro activated!', 'ultimate-store-kit')}
					</div>
				) : (
					<div className="rounded-lg border border-dashed border-gray-200 bg-gray-50 px-3 py-3 text-center">
						<p className="m-0 text-[11px] font-semibold uppercase tracking-wide text-gray-400">
							{__('Coming soon', 'ultimate-store-kit')}
						</p>
						<p className="mt-1.5 m-0 text-xs leading-snug text-gray-500">
							{__(
								'More store widgets & presets in future updates.',
								'ultimate-store-kit'
							)}
						</p>
					</div>
				)}
			</div>
		</div>
	);
};

export default Sidebar;
