import { __ } from '@wordpress/i18n';

const navItems = [
	{
		group: __('DASHBOARD', 'ultimate-store-kit'),
		items: [
			{
				id: 'welcome',
				label: __('Welcome', 'ultimate-store-kit'),
				icon: 'dashicons-admin-home',
			},
		],
	},
	{
		group: __('WIDGETS', 'ultimate-store-kit'),
		items: [
			{
				id: 'wc-widgets',
				label: __('WC Widgets', 'ultimate-store-kit'),
				icon: 'dashicons-cart',
			},
			{
				id: 'edd-widgets',
				label: __('EDD Widgets', 'ultimate-store-kit'),
				icon: 'dashicons-download',
			},
			{
				id: 'other-widgets',
				label: __('Other Widgets', 'ultimate-store-kit'),
				icon: 'dashicons-screenoptions',
			},
		],
	},
	{
		group: __('SETTINGS', 'ultimate-store-kit'),
		items: [
			{
				id: 'other-settings',
				label: __('Other Settings', 'ultimate-store-kit'),
				icon: 'dashicons-admin-generic',
			},
		],
	},
	{
		group: __('SUPPORT', 'ultimate-store-kit'),
		items: [
			{
				id: 'get-pro',
				label: __('Get Pro', 'ultimate-store-kit'),
				icon: 'dashicons-star-filled',
			},
			{
				id: 'license',
				label: __('License', 'ultimate-store-kit'),
				icon: 'dashicons-admin-network',
			},
			{
				id: 'about',
				label: __('About & Info', 'ultimate-store-kit'),
				icon: 'dashicons-info',
			},
		],
	},
];

const Sidebar = ({ activePage, onNavigate, isPro }) => {
	return (
		<div className="usk-admin-sidebar">
			<nav className="usk-admin-sidebar__nav">
				{navItems.map((group) => (
					<div key={group.group} className="usk-admin-sidebar__group">
						<div className="usk-admin-sidebar__group-label">
							{group.group}
						</div>
						<ul className="usk-admin-sidebar__list">
							{group.items.map((item) => {
								if (item.id === 'get-pro' && isPro) {
									return null;
								}
								return (
									<li key={item.id}>
										<button
											className={`usk-admin-sidebar__item ${activePage === item.id ? 'usk-admin-sidebar__item--active' : ''}`}
											onClick={() =>
												onNavigate(item.id)
											}
										>
											<span
												className={`dashicons ${item.icon}`}
											></span>
											<span>{item.label}</span>
										</button>
									</li>
								);
							})}
						</ul>
					</div>
				))}
			</nav>

			<div className="usk-admin-sidebar__promo">
				<div className="usk-admin-sidebar__promo-badge">
					{__('Coming Soon', 'ultimate-store-kit')}
				</div>
				<ul className="usk-admin-sidebar__promo-list">
					<li>{__('Advanced Search & Filters', 'ultimate-store-kit')}</li>
					<li>{__('Analytics Dashboard', 'ultimate-store-kit')}</li>
					<li>{__('User Reviews & Ratings', 'ultimate-store-kit')}</li>
					<li>{__('WooCommerce Integration', 'ultimate-store-kit')}</li>
				</ul>
			</div>
		</div>
	);
};

export default Sidebar;
