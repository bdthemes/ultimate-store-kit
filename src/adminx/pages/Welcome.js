import { useMemo } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
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

const Welcome = ({ widgets, settings }) => {
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
			<div className="rounded-lg border border-solid border-gray-100 bg-white p-4">
				<h3 className="mb-3 text-[13px] font-semibold uppercase tracking-wide text-slate-500">
					{title}
				</h3>
				<div className="flex items-center justify-between gap-3">
					<div className="flex flex-col gap-1">
						<div className="flex gap-1.5 text-[13px] text-slate-700">
							<span className="text-slate-400">
								{__('Active:', 'ultimate-store-kit')}
							</span>
							<strong>{data.active}</strong>
						</div>
						<div className="flex gap-1.5 text-[13px] text-slate-700">
							<span className="text-slate-400">
								{__('Inactive:', 'ultimate-store-kit')}
							</span>
							<strong>{data.inactive}</strong>
						</div>
						<div className="flex gap-1.5 text-[13px] text-slate-700">
							<span className="text-slate-400">
								{__('Total:', 'ultimate-store-kit')}
							</span>
							<strong>{data.total}</strong>
						</div>
					</div>
					<div className="h-[60px] w-[60px] shrink-0">
						<svg viewBox="0 0 36 36" className="h-full w-full">
							<path
								d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
								fill="none"
								stroke="#e2e8f0"
								strokeWidth="3"
							/>
							<path
								d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
								fill="none"
								stroke={color}
								strokeWidth="3"
								strokeDasharray={`${percentage}, 100`}
							/>
							<text
								x="18"
								y="20.5"
								className="font-bold"
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
		<div>
			<div className="mb-4 grid grid-cols-4 gap-4">
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

			<div className="mb-4 grid grid-cols-2 gap-4">
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

			<div className="grid grid-cols-2 gap-4">
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
