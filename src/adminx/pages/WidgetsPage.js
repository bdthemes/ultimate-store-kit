import { useState, useMemo, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const WidgetsPage = ({
	allWidgets,
	allSettings,
	onSave,
	saving,
	isPro,
}) => {
	const [widgetType, setWidgetType] = useState('wc');
	const [search, setSearch] = useState('');
	const [filter, setFilter] = useState('all');
	const [contentTypeFilter, setContentTypeFilter] = useState('all');

	const widgetTypeConfig = {
		wc: {
			title: __('WooCommerce Widgets', 'ultimate-store-kit'),
			key: 'ultimate_store_kit_active_modules',
		},
		edd: {
			title: __('EDD Widgets', 'ultimate-store-kit'),
			key: 'ultimate_store_kit_edd_modules',
		},
		other: {
			title: __('Other Widgets', 'ultimate-store-kit'),
			key: 'ultimate_store_kit_general_modules',
		},
	};

	const currentConfig = widgetTypeConfig[widgetType];
	const widgets = allWidgets[currentConfig.key] || [];
	const settings = allSettings[currentConfig.key] || {};

	const [localSettings, setLocalSettings] = useState(() => {
		const initial = {};
		Object.keys(allSettings).forEach((sectionKey) => {
			const sectionSettings = allSettings[sectionKey] || {};
			const sectionWidgets = allWidgets[sectionKey] || [];
			sectionWidgets.forEach((w) => {
				if (w.type !== 'checkbox') return;
				initial[w.name] =
					sectionSettings[w.name] !== undefined
						? sectionSettings[w.name]
						: w.default || 'off';
			});
		});
		return initial;
	});

	const contentTypes = useMemo(() => {
		const types = new Set();
		widgets.forEach((w) => {
			if (w.content_type) {
				w.content_type.split(' ').forEach((t) => {
					if (
						t &&
						t !== 'woocommerce' &&
						t !== 'edd' &&
						t !== 'new'
					) {
						types.add(t);
					}
				});
			}
		});
		return Array.from(types);
	}, [widgets]);

	const filteredWidgets = useMemo(() => {
		return widgets.filter((w) => {
			if (w.type !== 'checkbox') return false;

			if (search && !w.label.toLowerCase().includes(search.toLowerCase()))
				return false;

			if (filter === 'free' && w.widget_type !== 'free') return false;
			if (filter === 'pro' && w.widget_type !== 'pro') return false;

			if (
				contentTypeFilter !== 'all' &&
				(!w.content_type || !w.content_type.includes(contentTypeFilter))
			)
				return false;

			return true;
		});
	}, [widgets, search, filter, contentTypeFilter]);

	const handleToggle = useCallback(
		(name) => {
			setLocalSettings((prev) => ({
				...prev,
				[name]: prev[name] === 'on' ? 'off' : 'on',
			}));
		},
		[]
	);

	const handleActivateAll = useCallback(() => {
		setLocalSettings((prev) => {
			const updated = { ...prev };
			filteredWidgets.forEach((w) => {
				if (w.widget_type === 'pro' && !isPro) return;
				updated[w.name] = 'on';
			});
			return updated;
		});
	}, [filteredWidgets, isPro]);

	const handleDeactivateAll = useCallback(() => {
		setLocalSettings((prev) => {
			const updated = { ...prev };
			filteredWidgets.forEach((w) => {
				if (w.widget_type === 'pro' && !isPro) return;
				updated[w.name] = 'off';
			});
			return updated;
		});
	}, [filteredWidgets, isPro]);

	const handleSave = () => {
		const currentSettings = {};
		widgets.forEach((w) => {
			if (w.type === 'checkbox' && localSettings[w.name] !== undefined) {
				currentSettings[w.name] = localSettings[w.name];
			}
		});
		onSave(currentConfig.key, currentSettings);
	};

	const activeCount = Object.values(localSettings).filter(
		(v) => v === 'on'
	).length;

	return (
		<div className="usk-widgets-page">
			<div className="usk-widgets-page__header">
				<h2 className="usk-widgets-page__title">{currentConfig.title}</h2>
				<div className="usk-widgets-page__meta">
					<span className="usk-widgets-page__count">
						{activeCount} / {widgets.filter((w) => w.type === 'checkbox').length}{' '}
						{__('Active', 'ultimate-store-kit')}
					</span>
				</div>
			</div>

			<div className="usk-widgets-page__toolbar">
				<div className="usk-widgets-page__search">
					<span className="dashicons dashicons-search"></span>
					<input
						type="text"
						placeholder={__('Search widgets...', 'ultimate-store-kit')}
						value={search}
						onChange={(e) => setSearch(e.target.value)}
					/>
				</div>

				<div className="usk-widgets-page__filter-group">
					<label className="usk-select-label">
						{__('Widget Type:', 'ultimate-store-kit')}
					</label>
					<select
						className="usk-select"
						value={widgetType}
						onChange={(e) => setWidgetType(e.target.value)}
					>
						<option value="wc">{__('WooCommerce', 'ultimate-store-kit')}</option>
						<option value="edd">{__('EDD', 'ultimate-store-kit')}</option>
						<option value="other">{__('Other', 'ultimate-store-kit')}</option>
					</select>
				</div>

				<div className="usk-widgets-page__filter-group">
					<label className="usk-select-label">
						{__('Status:', 'ultimate-store-kit')}
					</label>
					<select
						className="usk-select"
						value={filter}
						onChange={(e) => setFilter(e.target.value)}
					>
						<option value="all">{__('All', 'ultimate-store-kit')}</option>
						<option value="free">{__('Free', 'ultimate-store-kit')}</option>
						<option value="pro">{__('Pro', 'ultimate-store-kit')}</option>
					</select>
				</div>

				{contentTypes.length > 0 && (
					<div className="usk-widgets-page__filter-group">
						<label className="usk-select-label">
							{__('Template:', 'ultimate-store-kit')}
						</label>
						<select
							className="usk-select"
							value={contentTypeFilter}
							onChange={(e) => setContentTypeFilter(e.target.value)}
						>
							<option value="all">{__('All Templates', 'ultimate-store-kit')}</option>
							{contentTypes.map((type) => (
								<option key={type} value={type}>
									{type.charAt(0).toUpperCase() + type.slice(1)}
								</option>
							))}
						</select>
					</div>
				)}

				<div className="usk-widgets-page__bulk">
					<button
						className="usk-btn usk-btn--small usk-btn--outline-green"
						onClick={handleActivateAll}
					>
						{__('Activate All', 'ultimate-store-kit')}
					</button>
					<button
						className="usk-btn usk-btn--small usk-btn--outline-red"
						onClick={handleDeactivateAll}
					>
						{__('Deactivate All', 'ultimate-store-kit')}
					</button>
				</div>
			</div>

			<div className="usk-widgets-grid">
				{filteredWidgets.length === 0 && (
					<div className="usk-widgets-grid__empty">
						{__('No widgets found.', 'ultimate-store-kit')}
					</div>
				)}
				{filteredWidgets.map((widget) => {
					const isProWidget = widget.widget_type === 'pro';
					const isDisabled = isProWidget && !isPro;
					const isActive =
						!isDisabled && localSettings[widget.name] === 'on';

					return (
						<div
							key={widget.name}
							className={`usk-widget-card ${isActive ? 'usk-widget-card--active' : ''} ${isDisabled ? 'usk-widget-card--disabled' : ''}`}
						>
							<div className="usk-widget-card__header">
								<span className="usk-widget-card__name">
									{widget.label}
								</span>
								{isProWidget && (
									<span className="usk-widget-card__badge">
										{__('Pro', 'ultimate-store-kit')}
									</span>
								)}
							</div>
							<div className="usk-widget-card__footer">
								<div className="usk-widget-card__links">
									{widget.demo_url &&
										!widget.demo_url.startsWith('#') && (
											<a
												href={widget.demo_url}
												target="_blank"
												rel="noopener noreferrer"
												title={__(
													'Demo',
													'ultimate-store-kit'
												)}
											>
												<span className="dashicons dashicons-visibility"></span>
											</a>
										)}
									{widget.video_url && (
										<a
											href={widget.video_url}
											target="_blank"
											rel="noopener noreferrer"
											title={__(
												'Video',
												'ultimate-store-kit'
											)}
										>
											<span className="dashicons dashicons-video-alt3"></span>
										</a>
									)}
								</div>
								<label className="usk-toggle">
									<input
										type="checkbox"
										checked={isActive}
										disabled={isDisabled}
										onChange={() =>
											handleToggle(widget.name)
										}
									/>
									<span className="usk-toggle__slider"></span>
								</label>
							</div>
						</div>
					);
				})}
			</div>

			<div className="usk-widgets-page__footer">
				<button
					className="usk-btn usk-btn--primary usk-btn--lg"
					onClick={handleSave}
					disabled={saving}
				>
					{saving
						? __('Saving...', 'ultimate-store-kit')
						: __('Save Changes', 'ultimate-store-kit')}
				</button>
			</div>
		</div>
	);
};

export default WidgetsPage;
