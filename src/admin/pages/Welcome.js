import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { applyFilters } from '@wordpress/hooks';
import WelcomeStatCard from '../components/WelcomeStatCard';
import { isWidgetEffectivelyOn } from '../utils';
import {
	btnEp,
	btnPg,
	btnPrimary,
	btnPs,
	btnSecondary,
	btnSm,
	btnUpk,
	btnZb,
} from '../tw';

const linkInline = 'font-semibold text-uks-brand hover:underline';

const Welcome = ({ widgets, settings, isPro = false }) => {
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
				if (!isPro && w.widget_type === 'pro') {
					inactive++;
					return;
				}
				const val = savedSettings[w.name];
				if (isWidgetEffectivelyOn(w, val, isPro)) {
					active++;
				} else {
					inactive++;
				}
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
	}, [widgets, settings, isPro]);

	return (
		<div>
			<div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
				<WelcomeStatCard
					title={__('All Widgets', 'ultimate-store-kit')}
					data={stats.all}
					color="#f59e0b"
				/>
				<WelcomeStatCard
					title={__('WooCommerce', 'ultimate-store-kit')}
					data={stats.wc}
					color="#ef4444"
				/>
				<WelcomeStatCard
					title={__('EDD', 'ultimate-store-kit')}
					data={stats.edd}
					color="#10b981"
				/>
				<WelcomeStatCard
					title={__('Other', 'ultimate-store-kit')}
					data={stats.other}
					color="#3b82f6"
				/>
			</div>

			{(() => {
				const WelcomeExtra = applyFilters('usk.admin.welcomeExtra', null);
				return WelcomeExtra ? <WelcomeExtra /> : null;
			})()}

			<div className="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
				<div className="rounded-lg border border-solid border-gray-100 bg-white p-5">
					<h3 className="m-0 mb-2 text-base font-bold text-slate-800">
						{__('Support And Feedback', 'ultimate-store-kit')}
					</h3>
					<p className="my-2 text-[13px] leading-relaxed text-slate-500">
						{__(
							'Feeling like to consult with an expert? Take live Chat support immediately from',
							'ultimate-store-kit'
						)}{' '}
						<a
							href="https://storekit.pro/"
							target="_blank"
							rel="noopener noreferrer"
							className={linkInline}
						>
							UltimateStoreKit
						</a>
						.{' '}
						{__(
							'We are always ready to help you 24/7.',
							'ultimate-store-kit'
						)}
					</p>
					<p className="my-2 text-[13px] leading-relaxed text-slate-500">
						<strong>
							{__(
								"Or if you're facing technical issues with our plugin, then please create a support ticket",
								'ultimate-store-kit'
							)}
						</strong>
					</p>
					<div className="mt-3 flex flex-wrap gap-2">
						<a
							className={btnPrimary}
							target="_blank"
							rel="noopener noreferrer"
							href="https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/"
						>
							{__('Knowledge Base', 'ultimate-store-kit')}
						</a>
						<a
							className={btnSecondary}
							target="_blank"
							rel="noopener noreferrer"
							href="https://bdthemes.com/support/"
						>
							{__('Get Support', 'ultimate-store-kit')}
						</a>
					</div>
				</div>

				<div className="rounded-lg border border-solid border-gray-100 bg-white p-5">
					<h3 className="m-0 mb-2 text-base font-bold text-slate-800">
						{__('System Requirement', 'ultimate-store-kit')}
					</h3>
					<p className="mb-3 text-[13px] leading-relaxed text-slate-500">
						{__(
							'Make sure your server meets the minimum requirements for optimal performance.',
							'ultimate-store-kit'
						)}
					</p>
					<div>
						<div className="flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0">
							<span>{__('PHP Version', 'ultimate-store-kit')}</span>
							<span className="rounded-lg bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800">
								{__('OK', 'ultimate-store-kit')}
							</span>
						</div>
						<div className="flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0">
							<span>{__('Memory Limit', 'ultimate-store-kit')}</span>
							<span className="rounded-lg bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800">
								{__('OK', 'ultimate-store-kit')}
							</span>
						</div>
						<div className="flex items-center justify-between border-b border-slate-100 py-2 text-[13px] text-slate-700 last:border-b-0">
							<span>{__('Max Execution Time', 'ultimate-store-kit')}</span>
							<span className="rounded-lg bg-emerald-100 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-800">
								{__('OK', 'ultimate-store-kit')}
							</span>
						</div>
					</div>
				</div>
			</div>

			<div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
				<div className="rounded-lg border border-solid border-gray-100 bg-white p-5">
					<h3 className="m-0 mb-2 text-base font-bold text-slate-800">
						{__('Feedback', 'ultimate-store-kit')}
					</h3>
					<p className="my-2 text-[13px] leading-relaxed text-slate-500">
						{__(
							'We are always looking for feedback from our users. If you have any suggestions or feedback, please let us know.',
							'ultimate-store-kit'
						)}
					</p>
					<div className="mt-3 flex flex-wrap gap-2">
						<a
							className={btnSecondary}
							target="_blank"
							rel="noopener noreferrer"
							href="https://feedback.bdthemes.com/b/6vr2250l/feature-requests/"
						>
							{__('Request Feature', 'ultimate-store-kit')}
						</a>
					</div>
				</div>

				<div className="rounded-lg border border-solid border-gray-100 bg-white p-5">
					<h3 className="m-0 mb-2 text-base font-bold text-slate-800">
						{__('Try Our Other Plugins', 'ultimate-store-kit')}
					</h3>
					<p className="my-2 text-[13px] leading-relaxed text-slate-500">
						{__(
							'Element Pack, Prime Slider, Ultimate Post Kit, Pixel Gallery & Live Copy Paste addons for Elementor.',
							'ultimate-store-kit'
						)}
					</p>
					<div className="mt-3 flex flex-wrap gap-2">
						<a
							className={`${btnSm} ${btnEp}`}
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/bdthemes-element-pack-lite/"
						>
							{__('Element Pack', 'ultimate-store-kit')}
						</a>
						<a
							className={`${btnSm} ${btnPs}`}
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/bdthemes-prime-slider-lite/"
						>
							{__('Prime Slider', 'ultimate-store-kit')}
						</a>
						<a
							className={`${btnSm} ${btnUpk}`}
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/ultimate-post-kit/"
						>
							{__('Ultimate Post Kit', 'ultimate-store-kit')}
						</a>
						<a
							className={`${btnSm} ${btnPg}`}
							target="_blank"
							rel="noopener noreferrer"
							href="https://wordpress.org/plugins/pixel-gallery/"
						>
							{__('Pixel Gallery', 'ultimate-store-kit')}
						</a>
						<a
							className={`${btnSm} ${btnZb}`}
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
