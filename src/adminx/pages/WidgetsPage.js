import { useState, useMemo, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const WidgetsPage = ({
	title,
	widgets,
	section,
	settings,
	onSave,
	saving,
	isPro,
}) => {
	const [localSettings, setLocalSettings] = useState(() => {
		const initial = {};
		widgets.forEach((w) => {
			if (w.type !== 'checkbox') return;
			initial[w.name] =
				settings[w.name] !== undefined
					? settings[w.name]
					: w.default || 'off';
		});
		return initial;
	});
	const [search, setSearch] = useState('');
	const [filter, setFilter] = useState('all');

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
				filter !== 'all' &&
				filter !== 'free' &&
				filter !== 'pro' &&
				(!w.content_type || !w.content_type.includes(filter))
			)
				return false;

			return true;
		});
	}, [widgets, search, filter]);

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
		onSave(section, localSettings);
	};

	const activeCount = Object.values(localSettings).filter(
		(v) => v === 'on'
	).length;

	return (
		<div className="usk-widgets-page">
			<div className="usk-widgets-page__header">
				<h2 className="usk-widgets-page__title">{title}</h2>
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
						placeholder={__(
							'Search widgets...',
							'ultimate-store-kit'
						)}
						value={search}
						onChange={(e) => setSearch(e.target.value)}
					/>
				</div>

				<div className="usk-widgets-page__filters">
					<button
						className={`usk-filter-btn ${filter === 'all' ? 'usk-filter-btn--active' : ''}`}
						onClick={() => setFilter('all')}
					>
						{__('All', 'ultimate-store-kit')}
					</button>
					<button
						className={`usk-filter-btn ${filter === 'free' ? 'usk-filter-btn--active' : ''}`}
						onClick={() => setFilter('free')}
					>
						{__('Free', 'ultimate-store-kit')}
					</button>
					<button
						className={`usk-filter-btn ${filter === 'pro' ? 'usk-filter-btn--active' : ''}`}
						onClick={() => setFilter('pro')}
					>
						{__('Pro', 'ultimate-store-kit')}
					</button>
					{contentTypes.map((type) => (
						<button
							key={type}
							className={`usk-filter-btn ${filter === type ? 'usk-filter-btn--active' : ''}`}
							onClick={() => setFilter(type)}
						>
							{type.charAt(0).toUpperCase() + type.slice(1)}
						</button>
					))}
				</div>

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
