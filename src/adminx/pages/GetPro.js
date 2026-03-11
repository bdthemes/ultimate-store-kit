import { __ } from '@wordpress/i18n';

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
			<div className="usk-getpro">
				<div className="usk-getpro__card">
					<h2>{__('You already have Pro!', 'ultimate-store-kit')}</h2>
					<p>{__('Thank you for being a Pro user. You have access to all features.', 'ultimate-store-kit')}</p>
				</div>
			</div>
		);
	}

	return (
		<div className="usk-getpro">
			<div className="usk-getpro__header">
				<div>
					<h2 className="usk-getpro__title">
						{__('WHY GO WITH PRO?', 'ultimate-store-kit')}
					</h2>
					<p className="usk-getpro__subtitle">
						{__('Just Compare With Ultimate Store Kit Free Vs Pro', 'ultimate-store-kit')}
					</p>
				</div>
				<a
					href="https://storekit.pro/pricing"
					target="_blank"
					rel="noopener noreferrer"
					className="usk-btn usk-btn--primary usk-btn--lg"
				>
					{__('Purchase Now', 'ultimate-store-kit')}
				</a>
			</div>

			<div className="usk-getpro__table">
				<div className="usk-getpro__table-head">
					<span>{__('Features', 'ultimate-store-kit')}</span>
					<span>{__('Free', 'ultimate-store-kit')}</span>
					<span>{__('Pro', 'ultimate-store-kit')}</span>
				</div>
				{features.map((f, i) => (
					<div key={i} className="usk-getpro__table-row">
						<span className="usk-getpro__feature-name">{f.label}</span>
						<span>
							{f.free ? (
								<span className="dashicons dashicons-yes-alt usk-getpro__icon--yes"></span>
							) : (
								<span className="dashicons dashicons-dismiss usk-getpro__icon--no"></span>
							)}
						</span>
						<span>
							{f.pro ? (
								<span className="dashicons dashicons-yes-alt usk-getpro__icon--yes"></span>
							) : (
								<span className="dashicons dashicons-dismiss usk-getpro__icon--no"></span>
							)}
						</span>
					</div>
				))}
			</div>

			<div className="usk-getpro__highlights">
				<div className="usk-getpro__highlights-grid">
					{highlights.map((h, i) => (
						<div key={i} className="usk-getpro__highlight-item">
							<span className="dashicons dashicons-heart"></span>
							<span>{h}</span>
						</div>
					))}
				</div>
				<div className="usk-getpro__cta">
					<a
						href="https://storekit.pro/pricing"
						target="_blank"
						rel="noopener noreferrer"
						className="usk-btn usk-btn--primary usk-btn--lg"
					>
						{__('Purchase Now', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default GetPro;
