import { __ } from '@wordpress/i18n';
import { GridIcon, LockIcon, StarIcon } from '../icons';

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
		<div>
			<div className="mb-4 flex items-center justify-between rounded-lg border border-solid border-gray-100 bg-white px-6 py-5">
				<div className="flex items-center gap-3">
					<div className="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100">
						<GridIcon className="h-5 w-5 text-slate-400" />
					</div>
					<div>
						<h3 className="m-0 text-base font-semibold text-slate-800">
							{info.title}
						</h3>
						<p className="m-0 text-sm text-slate-500">{info.description}</p>
					</div>
				</div>

				<div
					className="relative inline-flex h-6 w-11 shrink-0 cursor-not-allowed rounded-full border-2 border-solid border-transparent bg-gray-200 opacity-60"
					title={__('Pro feature', 'ultimate-store-kit')}
				>
					<span className="inline-block h-5 w-5 translate-x-0 rounded-full bg-white shadow ring-0 transition" />
				</div>
			</div>

			<div className="rounded-lg border border-solid border-gray-100 bg-white">
				<div className="flex flex-col items-center justify-center px-6 py-20 text-center">
					<div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
						<LockIcon className="h-7 w-7" stroke="#94a3b8" />
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
						<StarIcon className="h-4 w-4" />
						{__('Get Pro', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default ProModulePlaceholder;

