import { __ } from '@wordpress/i18n';
import Toggle from '../components/Toggle';

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

/** Matches Pro module header icon (inactive state). */
const ModuleHeaderIcon = ({ moduleId }) => {
	const wrap = 'flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400';

	if (moduleId === 'currency-switcher') {
		return (
			<div className={wrap} aria-hidden="true">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
					<circle cx="12" cy="12" r="10" />
					<path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
					<path d="M12 18V6" />
				</svg>
			</div>
		);
	}

	if (moduleId === 'variation-swatches') {
		return (
			<div className={wrap} aria-hidden="true">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
					<rect x="3" y="3" width="7" height="7" rx="1" />
					<rect x="14" y="3" width="7" height="7" rx="1" />
					<rect x="3" y="14" width="7" height="7" rx="1" />
					<rect x="14" y="14" width="7" height="7" rx="1" />
				</svg>
			</div>
		);
	}

	return (
		<div className={wrap} aria-hidden="true">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
				<path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
				<circle cx="12" cy="12" r="3" />
			</svg>
		</div>
	);
};

const ProModulePlaceholder = ({ moduleId }) => {
	const info = moduleInfo[moduleId] || {
		title: moduleId,
		description: '',
	};

	return (
		<div className="flex flex-col gap-5">
			{/* Same shell as Pro module header: rounded-usk card + real Toggle dimensions (disabled, off) */}
			<div className="flex flex-col gap-4 rounded-usk border border-solid border-gray-100 bg-white p-5 sm:flex-row sm:items-center sm:justify-between">
				<div className="flex min-w-0 items-center gap-3">
					<ModuleHeaderIcon moduleId={moduleId} />
					<div className="min-w-0">
						<h3 className="m-0 text-base font-bold text-slate-800">
							{info.title}
						</h3>
						<p className="m-0 mt-1 text-[12px] leading-snug text-slate-500">
							{info.description}
						</p>
					</div>
				</div>
				<div
					className="flex shrink-0 justify-end sm:pl-2"
					title={__('Pro feature — install Ultimate Store Kit Pro to enable.', 'ultimate-store-kit')}
				>
					<Toggle checked={false} disabled onChange={() => {}} />
				</div>
			</div>

			{/* Flat disabled card — aligned with Pro Swatches / Currency empty state */}
			<div className="rounded-usk border border-solid border-gray-100 bg-white p-8 sm:p-10">
				<div className="mx-auto max-w-lg text-center">
					<div
						className="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-uks-brand/10 text-uks-brand"
						aria-hidden="true"
					>
						<svg
							width="28"
							height="28"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							strokeWidth="1.75"
							strokeLinecap="round"
							strokeLinejoin="round"
						>
							<rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
							<path d="M7 11V7a5 5 0 0 1 10 0v4" />
						</svg>
					</div>
					<p className="m-0 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-400">
						{info.title}
					</p>
					<h4 className="m-0 mt-2 text-lg font-bold tracking-tight text-slate-800">
						{__('Module is currently disabled', 'ultimate-store-kit')}
					</h4>
					<p className="m-0 mt-3 text-[13px] leading-relaxed text-slate-500">
						{__(
							'This is a Pro feature. Upgrade to Ultimate Store Kit Pro to unlock this module and configure its settings.',
							'ultimate-store-kit'
						)}
					</p>
					<div className="mt-8">
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
		</div>
	);
};

export default ProModulePlaceholder;
