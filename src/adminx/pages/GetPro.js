import { __ } from '@wordpress/i18n';
import { btnLg, btnPrimary } from '../tw';

const features = [
	{ label: __('Core Widgets', 'ultimate-store-kit'), free: true, pro: true, note: 'Lite: 35+ / Pro: 100+' },
	{ label: __('Theme Compatibility', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Dynamic Content & Custom Fields', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Proper Documentation', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Updates & Support', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Ready Made Blocks', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Ready Made Pages', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Rooten Theme Pro Features', 'ultimate-store-kit'), free: false, pro: true },
	{ label: __('Priority Support', 'ultimate-store-kit'), free: false, pro: true },
];

const highlights = [
	__('Incredibly Advanced', 'ultimate-store-kit'),
	__('Refund or Cancel Anytime', 'ultimate-store-kit'),
	__('Dynamic Content', 'ultimate-store-kit'),
	__('Super-Flexible Widgets', 'ultimate-store-kit'),
	__('24/7 Premium Support', 'ultimate-store-kit'),
	__('Third Party Plugins', 'ultimate-store-kit'),
	__('Special Discount!', 'ultimate-store-kit'),
	__('Custom Field Integration', 'ultimate-store-kit'),
	__('With Live Chat Support', 'ultimate-store-kit'),
	__('Trusted Payment Methods', 'ultimate-store-kit'),
	__('Interactive Effects', 'ultimate-store-kit'),
	__('Video Tutorial', 'ultimate-store-kit'),
];

const GetPro = ({ isPro }) => {
	if (isPro) {
		return (
			<div>
				<div className="rounded-usk border border-slate-200 bg-white p-10 text-center">
					<h2 className="mb-2 text-uks-brand">
						{__('You already have Pro!', 'ultimate-store-kit')}
					</h2>
					<p className="m-0 text-slate-500">
						{__('Thank you for being a Pro user. You have access to all features.', 'ultimate-store-kit')}
					</p>
				</div>
			</div>
		);
	}

	return (
		<div>
			<div className="mb-6 flex items-center justify-between rounded-usk border border-slate-200 bg-white p-6">
				<div>
					<h2 className="mb-1 text-xl font-extrabold text-slate-800">
						{__('WHY GO WITH PRO?', 'ultimate-store-kit')}
					</h2>
					<p className="m-0 text-[13px] text-slate-500">
						{__('Just Compare With Ultimate Store Kit Free Vs Pro', 'ultimate-store-kit')}
					</p>
				</div>
				<a
					href="https://storekit.pro/pricing"
					target="_blank"
					rel="noopener noreferrer"
					className={`${btnLg} ${btnPrimary}`}
				>
					{__('Purchase Now', 'ultimate-store-kit')}
				</a>
			</div>

			<div className="mb-6 overflow-hidden rounded-usk border border-slate-200 bg-white">
				<div className="grid grid-cols-[2fr_1fr_1fr] bg-slate-800 px-5 py-3.5 text-center text-[13px] font-bold text-white">
					<span className="text-left">{__('Features', 'ultimate-store-kit')}</span>
					<span>{__('Free', 'ultimate-store-kit')}</span>
					<span>{__('Pro', 'ultimate-store-kit')}</span>
				</div>
				{features.map((f, i) => (
					<div
						key={i}
						className="grid grid-cols-[2fr_1fr_1fr] items-center border-b border-slate-100 px-5 py-3 text-center text-[13px] last:border-b-0 even:bg-slate-100"
					>
						<span className="text-left font-medium text-slate-700">{f.label}</span>
						<span>
							{f.free ? (
								<span className="dashicons dashicons-yes-alt text-uks-brand"></span>
							) : (
								<span className="dashicons dashicons-dismiss text-red-500"></span>
							)}
						</span>
						<span>
							{f.pro ? (
								<span className="dashicons dashicons-yes-alt text-uks-brand"></span>
							) : (
								<span className="dashicons dashicons-dismiss text-red-500"></span>
							)}
						</span>
					</div>
				))}
			</div>

			<div className="rounded-usk border border-slate-200 bg-white p-6">
				<div className="mb-5 grid grid-cols-[repeat(auto-fill,minmax(220px,1fr))] gap-3">
					{highlights.map((h, i) => (
						<div
							key={i}
							className="flex items-center gap-2 text-[13px] text-slate-700"
						>
							<span className="dashicons dashicons-heart text-sm text-red-500"></span>
							<span>{h}</span>
						</div>
					))}
				</div>
				<div className="border-t border-slate-200 pt-3 text-center">
					<a
						href="https://storekit.pro/pricing"
						target="_blank"
						rel="noopener noreferrer"
						className={`${btnLg} ${btnPrimary}`}
					>
						{__('Purchase Now', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default GetPro;
