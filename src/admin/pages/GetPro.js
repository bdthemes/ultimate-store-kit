import { __ } from '@wordpress/i18n';
import { btnLg, btnPrimary } from '../tw';

const features = [
	{ label: __('Core Widgets', 'ultimate-store-kit'), free: true, pro: true, freeNote: '35+', proNote: '100+' },
	{ label: __('Theme Compatibility', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Dynamic Content & Custom Fields', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Proper Documentation', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Updates & Support', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Ready Made Blocks', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Ready Made Pages', 'ultimate-store-kit'), free: true, pro: true },
	{ label: __('Rooten Theme Pro Features', 'ultimate-store-kit'), free: false, pro: true },
	{ label: __('Priority Support', 'ultimate-store-kit'), free: false, pro: true },
];

const HIcon = ({ d, viewBox = '0 0 24 24', filled = false }) => (
	<svg className="h-4 w-4 shrink-0 text-uks-brand" viewBox={viewBox} fill={filled ? 'currentColor' : 'none'} stroke={filled ? 'none' : 'currentColor'} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
		{Array.isArray(d) ? d.map((p, i) => <path key={i} d={p} />) : <path d={d} />}
	</svg>
);

const highlights = [
	{
		text: __('Incredibly Advanced', 'ultimate-store-kit'),
		icon: <HIcon d="M13 2 3 14h9l-1 8 10-12h-9l1-8z" />,
	},
	{
		text: __('Refund or Cancel Anytime', 'ultimate-store-kit'),
		icon: <HIcon d={['M9 14 4 9l5-5', 'M4 9h10.5a5.5 5.5 0 0 1 0 11H11']} />,
	},
	{
		text: __('Dynamic Content', 'ultimate-store-kit'),
		icon: <HIcon d={['M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z', 'M14 2v6h6', 'M8 13h8', 'M8 17h4']} />,
	},
	{
		text: __('Super-Flexible Widgets', 'ultimate-store-kit'),
		icon: <HIcon d={['M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z']} />,
	},
	{
		text: __('24/7 Premium Support', 'ultimate-store-kit'),
		icon: <HIcon d={['M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z']} />,
	},
	{
		text: __('Third Party Plugins', 'ultimate-store-kit'),
		icon: <HIcon d={['M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4z', 'm2 22 3-3', 'M7.5 13.5 10 11', 'M10.5 16.5 13 14', 'm18 3-4 4h6l-4 4']} />,
	},
	{
		text: __('Special Discount!', 'ultimate-store-kit'),
		icon: <HIcon d={['M9 5H2v7l6.29 6.29c.94.94 2.48.94 3.42 0l3.58-3.58c.94-.94.94-2.48 0-3.42L9 5z', 'M6 9.01V9']} />,
	},
	{
		text: __('Custom Field Integration', 'ultimate-store-kit'),
		icon: <HIcon d={['M12 20h9', 'M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z']} />,
	},
	{
		text: __('With Live Chat Support', 'ultimate-store-kit'),
		icon: <HIcon d={['M8 12h.01', 'M12 12h.01', 'M16 12h.01', 'M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z']} />,
	},
	{
		text: __('Trusted Payment Methods', 'ultimate-store-kit'),
		icon: <HIcon d={['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z']} />,
	},
	{
		text: __('Interactive Effects', 'ultimate-store-kit'),
		icon: <HIcon d={['M12 2v4', 'm16.2 7.8 2.9-2.9', 'M18 12h4', 'm16.2 16.2 2.9 2.9', 'M12 18v4', 'm4.9 19.1 2.9-2.9', 'M2 12h4', 'm4.9 4.9 2.9 2.9']} />,
	},
	{
		text: __('Video Tutorial', 'ultimate-store-kit'),
		icon: <HIcon d={['M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z', 'M9.75 15.02 15.5 12l-5.75-3.02v6.04z']} />,
	},
];

const StarIcon = ({ className = 'h-3.5 w-3.5' }) => (
	<svg className={className} viewBox="0 0 24 24" fill="currentColor">
		<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
	</svg>
);

const CheckIcon = () => (
	<svg className="mx-auto h-[18px] w-[18px] text-uks-brand" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
		<path d="M20 6 9 17l-5-5" />
	</svg>
);

const CrossIcon = () => (
	<svg className="mx-auto h-[18px] w-[18px] text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
		<path d="M18 6 6 18M6 6l12 12" />
	</svg>
);

const GetPro = ({ isPro }) => {
	if (isPro) {
		return (
			<div className="rounded-usk border border-slate-200 bg-white p-6 text-center sm:p-10">
				<div className="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100">
					<svg className="h-7 w-7 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
						<path d="M20 6 9 17l-5-5" />
					</svg>
				</div>
				<h2 className="m-0 mb-2 text-xl font-bold text-slate-800">
					{__('You already have Pro!', 'ultimate-store-kit')}
				</h2>
				<p className="m-0 text-sm text-slate-500">
					{__('Thank you for being a Pro user. You have access to all features.', 'ultimate-store-kit')}
				</p>
			</div>
		);
	}

	return (
		<div className="space-y-5">

			{/* Comparison Table */}
			<div className="overflow-hidden rounded-usk border border-solid border-gray-100 bg-white">

			{/* Header row */}
			<div className="flex border-b border-gray-100">
				<div className="flex flex-[2] items-center px-3 py-3 sm:px-5 sm:py-3.5">
					<span className="text-[10px] font-semibold uppercase tracking-wider text-slate-400 sm:text-[11px]">
						{__('Features', 'ultimate-store-kit')}
					</span>
				</div>
				<div className="flex w-20 items-center justify-center border-l border-gray-100 bg-slate-50 py-3 sm:w-28 sm:py-3.5 lg:w-36">
					<span className="text-[11px] font-bold text-slate-500 sm:text-[12px]">
						{__('Free', 'ultimate-store-kit')}
					</span>
				</div>
				<div className="flex w-20 items-center justify-center border-l border-uks-brand/30 bg-uks-brand py-3 sm:w-28 sm:py-3.5 lg:w-36">
					<span className="inline-flex items-center gap-1 text-[11px] font-bold text-white sm:gap-1.5 sm:text-[12px]">
						<StarIcon className="h-3 w-3" />
						{__('Pro', 'ultimate-store-kit')}
					</span>
				</div>
			</div>

			{/* Feature rows */}
			{features.map((f, i) => (
				<div
					key={i}
					className={`flex items-center border-b border-gray-50 last:border-b-0 ${i % 2 === 1 ? 'bg-slate-50/50' : 'bg-white'}`}
				>
					<div className="flex min-w-0 flex-[2] items-center gap-2 px-3 py-3 sm:px-5 sm:py-3.5">
						<span className="text-[12px] font-medium text-slate-700 sm:text-[13px]">
							{f.label}
						</span>
						{f.freeNote && f.proNote && (
							<span className="hidden shrink-0 rounded-full border border-slate-100 bg-white px-2 py-0.5 text-[10px] font-semibold text-slate-400 sm:inline-block">
								{f.freeNote} → {f.proNote}
							</span>
						)}
					</div>
					<div className={`flex w-20 shrink-0 items-center justify-center border-l py-3 sm:w-28 sm:py-3.5 lg:w-36 ${i % 2 === 1 ? 'border-gray-100 bg-slate-50/50' : 'border-gray-50 bg-white'}`}>
						{f.free ? <CheckIcon /> : <CrossIcon />}
					</div>
					<div className="flex w-20 shrink-0 items-center justify-center border-l border-uks-brand/20 bg-uks-brand/[0.07] py-3 sm:w-28 sm:py-3.5 lg:w-36">
						{f.pro ? <CheckIcon /> : <CrossIcon />}
					</div>
				</div>
			))}
			</div>

			{/* What's included + CTA */}
			<div className="overflow-hidden rounded-usk border border-solid border-gray-100 bg-white">

			{/* Highlights grid */}
			<div className="p-4 sm:p-5 lg:p-6">
				<p className="m-0 mb-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 sm:mb-4">
					{__("What's included with Pro", 'ultimate-store-kit')}
				</p>
				<div className="grid grid-cols-1 gap-2 xs:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
					{highlights.map((h, i) => (
						<div
							key={i}
							className="flex items-center gap-2 rounded-lg border border-slate-100 bg-slate-50/70 px-3 py-2.5 sm:gap-2.5"
						>
							<span className="shrink-0" aria-hidden="true">{h.icon}</span>
							<span className="text-[12px] font-medium leading-snug text-slate-600">{h.text}</span>
						</div>
					))}
				</div>
			</div>

			{/* CTA strip */}
			<div className="flex flex-col items-center gap-3 border-t border-uks-brand/15 bg-gradient-to-br from-uks-brand/[0.07] to-transparent px-4 py-5 text-center sm:px-6 sm:py-6">
				<p className="m-0 text-[13px] font-semibold text-slate-700">
					{__('Ready to unlock all Pro features?', 'ultimate-store-kit')}
				</p>
				<a
					href="https://storekit.pro/pricing"
					target="_blank"
					rel="noopener noreferrer"
					className={`${btnLg} ${btnPrimary} gap-2`}
				>
					<StarIcon className="h-4 w-4" />
					{__('Upgrade to Pro — View Pricing', 'ultimate-store-kit')}
				</a>
				<div className="flex flex-wrap items-center justify-center gap-x-4 gap-y-1.5 text-[11px] text-slate-400">
					<span className="flex items-center gap-1">
						<svg className="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
						{__('30-day money-back', 'ultimate-store-kit')}
					</span>
					<span className="flex items-center gap-1">
						<svg className="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
						{__('Cancel anytime', 'ultimate-store-kit')}
					</span>
					<span className="flex items-center gap-1">
						<svg className="h-3.5 w-3.5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><path d="M20 6 9 17l-5-5" /></svg>
						{__('Instant access', 'ultimate-store-kit')}
					</span>
				</div>
			</div>
			</div>

		</div>
	);
};

export default GetPro;
