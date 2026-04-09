import { __ } from '@wordpress/i18n';
import { btnPrimary, btnSm, fieldControl, fieldLabel, fieldRow, proBadge } from '../tw';

const PRO_URL = 'https://bdthemes.com/ultimate-store-kit/';

const promoSettings = [
	{
		group: __('Sales Notifications', 'ultimate-store-kit'),
		description: __(
			'Configure flash sale banners, countdown timers, and promotional badges for your store.',
			'ultimate-store-kit'
		),
		fields: [
			{
				name: 'enable_flash_sale',
				type: 'checkbox',
				label: __('Enable Flash Sale Banner', 'ultimate-store-kit'),
				description: __(
					'Display a site-wide flash sale banner on product pages.',
					'ultimate-store-kit'
				),
			},
			{
				name: 'flash_sale_text',
				type: 'text',
				label: __('Flash Sale Text', 'ultimate-store-kit'),
				placeholder: __('🔥 Flash Sale — Up to 50% OFF!', 'ultimate-store-kit'),
			},
			{
				name: 'sale_badge_style',
				type: 'select',
				label: __('Sale Badge Style', 'ultimate-store-kit'),
				options: {
					default: __('Default', 'ultimate-store-kit'),
					ribbon: __('Ribbon', 'ultimate-store-kit'),
					circle: __('Circle', 'ultimate-store-kit'),
					starburst: __('Starburst', 'ultimate-store-kit'),
				},
			},
			{
				name: 'sale_badge_color',
				type: 'color',
				label: __('Sale Badge Color', 'ultimate-store-kit'),
				value: '#ef4444',
			},
			{
				name: 'enable_countdown_timer',
				type: 'checkbox',
				label: __('Enable Sale Countdown Timer', 'ultimate-store-kit'),
				description: __(
					'Show a countdown timer on products that have a sale end date.',
					'ultimate-store-kit'
				),
			},
			{
				name: 'countdown_position',
				type: 'select',
				label: __('Countdown Position', 'ultimate-store-kit'),
				options: {
					above_price: __('Above Price', 'ultimate-store-kit'),
					below_price: __('Below Price', 'ultimate-store-kit'),
					above_button: __('Above Add to Cart', 'ultimate-store-kit'),
				},
			},
			{
				name: 'minimum_discount_percent',
				type: 'number',
				label: __(
					'Minimum Discount % to Show Badge',
					'ultimate-store-kit'
				),
				value: '5',
				description: __(
					'Only show the sale badge when the discount is at least this percentage.',
					'ultimate-store-kit'
				),
			},
		],
	},
];

const ProPromo = () => {
	return (
		<div className="pointer-events-none relative select-none opacity-70">
			<div className="pointer-events-auto mb-4 flex items-center justify-between rounded-usk border border-uks-brand bg-[linear-gradient(313deg,#E62A3F_0%,#00216A_100%)] px-5 py-3.5">
				<div className="flex items-center gap-2.5">
					<span className="rounded-[10px] bg-[linear-gradient(313deg,#E62A3F_0%,#00216A_100%)] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-white">
						{__('Pro', 'ultimate-store-kit')}
					</span>
					<span className="text-sm font-semibold text-white/90">
						{__(
							'Unlock these premium settings with Ultimate Store Kit Pro',
							'ultimate-store-kit'
						)}
					</span>
				</div>
				<a href={PRO_URL} target="_blank" rel="noopener noreferrer" className={`${btnSm} ${btnPrimary}`}>
					{__('Get Pro', 'ultimate-store-kit')}
				</a>
			</div>

			{promoSettings.map((group, gi) => (
				<div
					key={gi}
					className="relative mb-4 overflow-hidden rounded-usk border border-slate-200 bg-white"
				>
					<div className="border-l-[3px] border-uks-brand">
						<h3 className="m-0 flex flex-wrap items-center gap-2 border-b border-slate-200 bg-slate-100 px-5 py-3.5 text-sm font-bold text-slate-800">
							{group.group}
							<span className={proBadge}>
								{__('Pro', 'ultimate-store-kit')}
							</span>
						</h3>
						{group.description && (
							<p className="m-0 px-5 pt-1 text-[13px] leading-relaxed text-slate-400">
								{group.description}
							</p>
						)}
						<div className="px-5 py-2 opacity-60">
							{group.fields.map((field) => {
								if (field.type === 'checkbox') {
									return (
										<div
											key={field.name}
											className={`${fieldRow} flex-wrap`}
										>
											<div className={fieldLabel}>
												<span>{field.label}</span>
											</div>
											<div className="h-[22px] w-10 rounded-full bg-slate-200" />
											{field.description && (
												<p className="mt-1 w-full text-xs leading-snug text-slate-400">
													{field.description}
												</p>
											)}
										</div>
									);
								}

								if (field.type === 'select') {
									const defaultValue = Object.keys(field.options)[0];
									return (
										<div key={field.name} className={fieldRow}>
											<label className={fieldLabel}>
												{field.label}
											</label>
											<select
												className={`${fieldControl} cursor-not-allowed opacity-60`}
												disabled
												defaultValue={defaultValue}
											>
												{Object.entries(
													field.options
												).map(([val, lbl]) => (
													<option
														key={val}
														value={val}
													>
														{lbl}
													</option>
												))}
											</select>
										</div>
									);
								}

								if (field.type === 'color') {
									return (
										<div key={field.name} className={fieldRow}>
											<label className={fieldLabel}>
												{field.label}
											</label>
											<input
												type="color"
												disabled
												value={field.value || '#000000'}
												readOnly
												className="h-8 w-12 cursor-not-allowed rounded-md border border-slate-200 p-0.5 opacity-60"
											/>
										</div>
									);
								}

								if (
									field.type === 'number' ||
									field.type === 'text'
								) {
									return (
										<div key={field.name} className={fieldRow}>
											<label className={fieldLabel}>
												{field.label}
											</label>
											<input
												type={field.type}
												className={`${fieldControl} cursor-not-allowed opacity-60`}
												disabled
												placeholder={
													field.placeholder || ''
												}
												defaultValue={
													field.value || ''
												}
												readOnly
											/>
											{field.description && (
												<p className="mt-1 w-full text-xs leading-snug text-slate-400">
													{field.description}
												</p>
											)}
										</div>
									);
								}

								return null;
							})}
						</div>
					</div>
				</div>
			))}
		</div>
	);
};

export default ProPromo;
