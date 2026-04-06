import { __ } from '@wordpress/i18n';

const moduleInfo = {
	'currency-switcher': {
		title: __('Currency Switcher', 'ultimate-store-kit'),
		description: __(
			'Enable to allow currency switching on your store.',
			'ultimate-store-kit'
		),
	},
	'variation-swatches': {
		title: __('Variation Swatches', 'ultimate-store-kit'),
		description: __(
			'Enable to display product variation swatches on your store.',
			'ultimate-store-kit'
		),
	},
};

const ProModulePlaceholder = ({ moduleId }) => {
	const info = moduleInfo[moduleId] || {
		title: moduleId,
		description: '',
	};

	return (
		<div className="">
			{/* Header with disabled toggle */}
			<div className="mb-4 flex items-center justify-between rounded-lg border border-solid border-gray-100 bg-white px-6 py-5">
				<div className="flex items-center gap-3">
					<div className="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width={20}
							height={20}
							viewBox="0 0 24 24"
							fill="none"
							stroke="#94a3b8"
							strokeWidth={2}
							strokeLinecap="round"
							strokeLinejoin="round"
						>
							<path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
							<circle cx={12} cy={12} r={3} />
						</svg>
					</div>
					<div>
						<h3 className="m-0 text-base font-semibold text-slate-800">
							{info.title}
						</h3>
						<p className="m-0 text-sm text-slate-500">
							{info.description}
						</p>
					</div>
				</div>

				{/* Disabled toggle */}
				<div
					className="relative inline-flex h-6 w-11 shrink-0 cursor-not-allowed rounded-full border-2 border-solid border-transparent bg-gray-200 opacity-60"
					title={__('Pro feature', 'ultimate-store-kit')}
				>
					<span className="inline-block h-5 w-5 translate-x-0 rounded-full bg-white shadow ring-0 transition" />
				</div>
			</div>

			{/* Disabled state content */}
			<div className="rounded-lg border border-solid border-gray-100 bg-white">
				<div className="flex flex-col items-center justify-center py-20 px-6 text-center">
					<div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width={28}
							height={28}
							viewBox="0 0 24 24"
							fill="none"
							stroke="#94a3b8"
							strokeWidth={2}
							strokeLinecap="round"
							strokeLinejoin="round"
						>
							<rect width={18} height={11} x={3} y={11} rx={2} ry={2} />
							<path d="M7 11V7a5 5 0 0 1 10 0v4" />
						</svg>
					</div>
					<h4 className="m-0 mb-2 text-lg font-semibold text-slate-700">
						{__('Module is currently disabled', 'ultimate-store-kit')}
					</h4>
					<p className="m-0 mb-6 max-w-md text-sm leading-relaxed text-slate-500">
						{__(
							'This is a Pro feature. Upgrade to Ultimate Store Kit Pro to unlock this module and configure its settings.',
							'ultimate-store-kit'
						)}
					</p>
					<a
						href="https://storekit.pro/pricing/"
						target="_blank"
						rel="noopener noreferrer"
						className="inline-flex items-center gap-2 rounded-lg border-0 bg-uks-brand px-5 py-2.5 text-sm font-semibold text-white no-underline transition-opacity hover:opacity-90"
					>
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width={16}
							height={16}
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							strokeWidth={2}
							strokeLinecap="round"
							strokeLinejoin="round"
						>
							<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
						</svg>
						{__('Get Pro', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default ProModulePlaceholder;
