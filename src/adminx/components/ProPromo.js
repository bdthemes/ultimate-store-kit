import { __ } from '@wordpress/i18n';

const promoSettings = [
	{
		group: __('Sales Controls', 'ultimate-store-kit'),
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
		<div className="usk-pro-promo">
			<div className="usk-pro-promo__banner">
				<div className="usk-pro-promo__banner-content">
					<span className="usk-pro-promo__badge">
						{__('Pro', 'ultimate-store-kit')}
					</span>
					<span className="usk-pro-promo__banner-text">
						{__(
							'Unlock these premium settings with Ultimate Store Kit Pro',
							'ultimate-store-kit'
						)}
					</span>
				</div>
				<a
					href="https://bdthemes.com/ultimate-store-kit/"
					target="_blank"
					rel="noopener noreferrer"
					className="usk-btn usk-btn--primary usk-btn--sm"
				>
					{__('Get Pro', 'ultimate-store-kit')}
				</a>
			</div>

			{promoSettings.map((group, gi) => (
				<div
					key={gi}
					className="usk-settings-group usk-pro-promo__group"
				>
					<h3 className="usk-settings-group__title">
						{group.group}
						<span className="usk-widget-card__badge">
							{__('Pro', 'ultimate-store-kit')}
						</span>
					</h3>
					{group.description && (
						<p className="usk-pro-promo__group-desc">
							{group.description}
						</p>
					)}
					<div className="usk-settings-group__body">
						{group.fields.map((field) => {
							if (field.type === 'checkbox') {
								return (
									<div
										key={field.name}
										className="usk-settings-field"
									>
										<div className="usk-settings-field__label">
											<span>{field.label}</span>
										</div>
										<label className="usk-toggle">
											<input
												type="checkbox"
												checked={false}
												disabled
												readOnly
											/>
											<span className="usk-toggle__slider"></span>
										</label>
										{field.description && (
											<p className="usk-pro-promo__field-desc">
												{field.description}
											</p>
										)}
									</div>
								);
							}

							if (field.type === 'select') {
								return (
									<div
										key={field.name}
										className="usk-settings-field"
									>
										<label className="usk-settings-field__label">
											{field.label}
										</label>
										<select
											className="usk-settings-field__select"
											disabled
											defaultValue={
												Object.keys(
													field.options
												)[0]
											}
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
									<div
										key={field.name}
										className="usk-settings-field"
									>
										<label className="usk-settings-field__label">
											{field.label}
										</label>
										<input
											type="color"
											disabled
											value={field.value || '#000000'}
											readOnly
											style={{
												width: 48,
												height: 32,
												padding: 2,
												border: '1px solid #e2e8f0',
												borderRadius: 6,
												cursor: 'not-allowed',
											}}
										/>
									</div>
								);
							}

							if (
								field.type === 'number' ||
								field.type === 'text'
							) {
								return (
									<div
										key={field.name}
										className="usk-settings-field"
									>
										<label className="usk-settings-field__label">
											{field.label}
										</label>
										<input
											type={field.type}
											className="usk-settings-field__input"
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
											<p className="usk-pro-promo__field-desc">
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
			))}
		</div>
	);
};

export default ProPromo;
