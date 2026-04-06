import { __ } from '@wordpress/i18n';

const widgetTypeItems = [
	{
		id: 'wc',
		label: __('WooCommerce Widgets', 'ultimate-store-kit'),
		icon: 'woocommerce',
	},
	{
		id: 'edd',
		label: __('Easy Digital Downloads Widgets', 'ultimate-store-kit'),
		icon: 'edd',
	},
	{
		id: 'other',
		label: __('Other Widgets', 'ultimate-store-kit'),
		icon: 'other',
	},
];

const Icon = ({ name }) => {
	const common = 'h-5 w-5 block';
	switch (name) {
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
					<circle cx={9} cy={9} r={2} />
					<path d="M20 11.5v-1a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h2" />
					<path d="M4 15h12a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2" />
					<path d="M22 15h-4" />
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
					<rect width={7} height={9} x={3} y={3} rx={1} />
					<rect width={7} height={5} x={14} y={3} rx={1} />
					<rect width={7} height={9} x={14} y={12} rx={1} />
					<rect width={7} height={5} x={3} y={16} rx={1} />
				</svg>
			);
	}
};

const WidgetsSidebar = ({ activeType, onTypeChange, isDesktop }) => {
	const content = (
		<nav className="flex flex-col" aria-label="Widget Types">
			<p className="m-0 mb-3 px-2 text-xs font-semibold uppercase tracking-widest text-gray-400">
				{__('Widget Types', 'ultimate-store-kit')}
			</p>
			<ul className="m-0 list-none space-y-1 p-0">
				{widgetTypeItems.map((item) => {
					const isActive = activeType === item.id;
					return (
						<li key={item.id}>
							<button
								type="button"
								onClick={() => onTypeChange(item.id)}
								className={`flex w-full cursor-pointer items-center gap-3 rounded-lg border-0 px-3 py-3 text-left text-sm font-medium transition-colors ${
									isActive
										? 'bg-uks-brand text-white shadow-sm'
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
		</nav>
	);

	if (isDesktop) {
		return (
			<div className="w-56 shrink-0 rounded-lg border border-solid border-gray-100 bg-white px-4 py-6 self-start sticky top-4">
				{content}
			</div>
		);
	}

	const activeItem = widgetTypeItems.find((item) => item.id === activeType);

	return (
		<div className="mb-4">
			<select
				className="block w-full rounded-md border border-solid border-gray-200 bg-white py-2.5 px-3 text-sm text-slate-700 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand/25"
				value={activeType}
				onChange={(e) => onTypeChange(e.target.value)}
			>
				{widgetTypeItems.map((item) => (
					<option key={item.id} value={item.id}>
						{item.label}
					</option>
				))}
			</select>
		</div>
	);
};

export default WidgetsSidebar;
