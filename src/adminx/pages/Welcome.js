import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const Welcome = ({ widgets, settings, isPro }) => {
	const stats = useMemo(() => {
		const wcWidgets = widgets.ultimate_store_kit_active_modules || [];
		const eddWidgets = widgets.ultimate_store_kit_edd_modules || [];
		const otherWidgets = widgets.ultimate_store_kit_general_modules || [];

		const wcSettings = settings.ultimate_store_kit_active_modules || {};
		const eddSettings = settings.ultimate_store_kit_edd_modules || {};
		const otherSettings = settings.ultimate_store_kit_general_modules || {};

		const countActive = (widgetList, savedSettings) => {
			let active = 0;
			let inactive = 0;
			widgetList.forEach((w) => {
				if (w.type !== 'checkbox') return;
				const val = savedSettings[w.name];
				const isOn =
					val !== undefined ? val === 'on' : w.default === 'on';
				if (isOn) active++;
				else inactive++;
			});
			return { active, inactive, total: active + inactive };
		};

		const wc = countActive(wcWidgets, wcSettings);
		const edd = countActive(eddWidgets, eddSettings);
		const other = countActive(otherWidgets, otherSettings);

		const all = {
			active: wc.active + edd.active + other.active,
			inactive: wc.inactive + edd.inactive + other.inactive,
			total: wc.total + edd.total + other.total,
		};

		return { all, wc, edd, other };
	}, [widgets, settings]);

	const StatCard = ({ title, data, color }) => {
		const percentage =
			data.total > 0 ? Math.round((data.active / data.total) * 100) : 0;
		return (
			<div className="usk-stat-card">
				<h3 className="usk-stat-card__title">{title}</h3>
				<div className="usk-stat-card__body">
					<div className="usk-stat-card__counts">
						<div className="usk-stat-card__count">
							<span className="usk-stat-card__label">
								{__('Active:', 'ultimate-store-kit')}
							</span>
							<strong>{data.active}</strong>
						</div>
						<div className="usk-stat-card__count">
							<span className="usk-stat-card__label">
								{__('Inactive:', 'ultimate-store-kit')}
							</span>
							<strong>{data.inactive}</strong>
						</div>
						<div className="usk-stat-card__count">
							<span className="usk-stat-card__label">
								{__('Total:', 'ultimate-store-kit')}
							</span>
							<strong>{data.total}</strong>
						</div>
					</div>
					<div className="usk-stat-card__chart">
						<svg viewBox="0 0 36 36" className="usk-donut">
							<path
								className="usk-donut__ring"
								d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
								fill="none"
								stroke="#e2e8f0"
								strokeWidth="3"
							/>
							<path
								className="usk-donut__segment"
								d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
								fill="none"
								stroke={color}
								strokeWidth="3"
								strokeDasharray={`${percentage}, 100`}
							/>
							<text
								x="18"
								y="20.5"
								className="usk-donut__text"
								textAnchor="middle"
								fontSize="8"
								fill="#334155"
							>
								{percentage}%
							</text>
						</svg>
					</div>
				</div>
			</div>
		);
	};

	return (
		<div className="usk-welcome">
			<div className="usk-welcome__stats">
				<StatCard
					title={__('All Widgets', 'ultimate-store-kit')}
					data={stats.all}
					color="#f59e0b"
				/>
				<StatCard
					title={__('WooCommerce', 'ultimate-store-kit')}
					data={stats.wc}
					color="#ef4444"
				/>
				<StatCard
					title={__('EDD', 'ultimate-store-kit')}
					data={stats.edd}
					color="#10b981"
				/>
				<StatCard
					title={__('Other', 'ultimate-store-kit')}
					data={stats.other}
					color="#3b82f6"
				/>
			</div>

			<div className="usk-welcome__grid">
				<div className="usk-welcome__card">
					<h3 className="usk-welcome__card-title">
						{__('Support And Feedback', 'ultimate-store-kit')}
					</h3>
					<p>
						{__(
							'Feeling like to consult with an expert? Take live Chat support immediately from',
							'ultimate-store-kit'
						)}{' '}
						<a
							href="https://storekit.pro/"
							target="_blank"
							rel="noopener noreferrer"
						>
							UltimateStoreKit
						</a>
						.{' '}
						{__(
							'We are always ready to help you 24/7.',
							'ultimate-store-kit'
						)}
					</p>
					<p>
						<strong>
							{__(
								"Or if you're facing technical issues with our plugin, then please create a support ticket",
								'ultimate-store-kit'
							)}
						</strong>
					</p>
					<div className="usk-welcome__card-actions">
						<a
							className="usk-btn usk-btn--primary"
							target="_blank"
							rel="noopener noreferrer"
							href="https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/"
						>
							{__('Knowledge Base', 'ultimate-store-kit')}
						</a>
						<a
							className="usk-btn usk-btn--secondary"
							target="_blank"
							rel="noopener noreferrer"
							href="https://bdthemes.com/support/"
						>
							{__('Get Support', 'ultimate-store-kit')}
						</a>
					</div>
				</div>

				<div className="usk-welcome__card">
					<h3 className="usk-welcome__card-title">
						{__('System Requirement', 'ultimate-store-kit')}
					</h3>
					<p className="usk-welcome__card-desc">
						{__(
							'Make sure your server meets the minimum requirements for optimal performance.',
							'ultimate-store-kit'
						)}
					</p>
					<div className="usk-system-info">
						<div className="usk-system-info__item">
							<span>{__('PHP Version', 'ultimate-store-kit')}</span>
							<span className="usk-system-info__badge usk-system-info__badge--ok">
								{__('OK', 'ultimate-store-kit')}
							</span>
						</div>
						<div className="usk-system-info__item">
							<span>{__('Memory Limit', 'ultimate-store-kit')}</span>
							<span className="usk-system-info__badge usk-system-info__badge--ok">
								{__('OK', 'ultimate-store-kit')}
							</span>
						</div>
						<div className="usk-system-info__item">
							<span>{__('Max Execution Time', 'ultimate-store-kit')}</span>
							<span className="usk-system-info__badge usk-system-info__badge--ok">
								{__('OK', 'ultimate-store-kit')}
							</span>
						</div>
					</div>
				</div>
			</div>

			<div className="usk-welcome__grid">
				<div className="usk-welcome__card">
					<h3 className="usk-welcome__card-title">
						{__('Feedback', 'ultimate-store-kit')}
					</h3>
					<p>
						{__(
							'We are always looking for feedback from our users. If you have any suggestions or feedback, please let us know.',
							'ultimate-store-kit'
						)}
					</p>
					<div className="usk-welcome__card-actions">
						<a
							className="usk-btn usk-btn--secondary"
							target="_blank"
							rel="noopener noreferrer"
							href="https://feedback.bdthemes.com/b/6vr2250l/feature-requests/"
						>
							{__('Request Feature', 'ultimate-store-kit')}
						</a>
					</div>
				</div>

				<div className="usk-welcome__card">
					<h3 className="usk-welcome__card-title">
						{__('Try Our Other Plugins', 'ultimate-store-kit')}
					</h3>
					<p>
						{__(
							'Element Pack, Prime Slider, Ultimate Post Kit, Pixel Gallery & Live Copy Paste addons for Elementor.',
							'ultimate-store-kit'
						)}
					</p>
					<div className="usk-welcome__card-actions usk-welcome__card-actions--wrap">
						<a
							className="usk-btn usk-btn--small usk-btn--ep"
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/bdthemes-element-pack-lite/"
						>
							{__('Element Pack', 'ultimate-store-kit')}
						</a>
						<a
							className="usk-btn usk-btn--small usk-btn--ps"
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/bdthemes-prime-slider-lite/"
						>
							{__('Prime Slider', 'ultimate-store-kit')}
						</a>
						<a
							className="usk-btn usk-btn--small usk-btn--upk"
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/ultimate-post-kit/"
						>
							{__('Ultimate Post Kit', 'ultimate-store-kit')}
						</a>
						<a
							className="usk-btn usk-btn--small usk-btn--pg"
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/pixel-gallery/"
						>
							{__('Pixel Gallery', 'ultimate-store-kit')}
						</a>
						<a
							className="usk-btn usk-btn--small usk-btn--zb"
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/zoloblocks/"
						>
							{__('ZoloBlocks', 'ultimate-store-kit')}
						</a>
					</div>
				</div>
			</div>
		</div>
	);
};

export default Welcome;
