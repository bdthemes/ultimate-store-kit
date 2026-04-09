import { __ } from '@wordpress/i18n';
import Icon from '../components/Icon';
import { LockIcon, StarIcon } from '../icons';

/** Visual match for BrandToggle “off” state — inline styles so WP admin CSS cannot wash it out */
const ProLockedTogglePreview = () => (
	<div
		className="relative inline-flex shrink-0 cursor-not-allowed select-none"
		style={{ width: 40, height: 22 }}
		role="presentation"
		aria-hidden="true"
		title={__('Requires Pro license', 'ultimate-store-kit')}
	>
		<span
			style={{
				position: 'absolute',
				inset: 0,
				borderRadius: 9999,
				background: '#cbd5e1',
				border: '1px solid #94a3b8',
				boxSizing: 'border-box',
			}}
		/>
		<span
			style={{
				position: 'absolute',
				top: '50%',
				left: 3,
				width: 16,
				height: 16,
				marginTop: -8,
				borderRadius: 9999,
				background: '#ffffff',
				boxShadow: '0 1px 4px rgba(0,0,0,0.22)',
			}}
		/>
	</div>
);

const ProModulePlaceholder = ({ module }) => {
	const title = module?.label || module?.id || '';
	const description = module?.description || '';
	const iconName = module?.icon || module?.id || 'grid';

	const cardShell =
		'rounded-usk border border-solid border-gray-100 bg-white';

	return (
		<div className="flex flex-col gap-5">
			<div
				className={`flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between ${cardShell}`}
			>
				<div className="flex min-w-0 items-center gap-3">
					<div
						className="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-uks-brand/10 text-uks-brand"
						aria-hidden="true"
					>
						<Icon name={iconName} />
					</div>
					<div className="min-w-0">
						<h3 className="m-0 text-base font-bold text-slate-800">{title}</h3>
						{description && (
							<p className="m-0 mt-1 text-[12px] leading-snug text-slate-500">
								{description}
							</p>
						)}
					</div>
				</div>
				<div className="flex shrink-0 justify-end sm:pl-2">
					<ProLockedTogglePreview />
				</div>
			</div>

			<div className={cardShell}>
				<div className="flex flex-col items-center justify-center px-6 py-16 text-center sm:px-10 sm:py-20">
					<div
						className="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-uks-brand/10 text-uks-brand"
						aria-hidden="true"
					>
						<LockIcon className="h-7 w-7" stroke="currentColor" />
					</div>
					<h4 className="m-0 mb-2 text-lg font-bold tracking-tight text-slate-800">
						{__('Module is currently disabled', 'ultimate-store-kit')}
					</h4>
					<p className="m-0 mb-6 max-w-md text-[13px] leading-relaxed text-slate-500">
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
