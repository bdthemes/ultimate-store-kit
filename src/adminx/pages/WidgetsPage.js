import { useState, useMemo, useCallback, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	btnLg,
	btnOutlineGreen,
	btnOutlineRed,
	btnPrimary,
	btnSm,
	proBadge,
	selectInput,
	selectLabel,
	toggleInput,
	toggleKnob,
	toggleLabel,
	toggleTrack,
} from '../tw';

const getFiltersFromHash = () => {
	const hash = window.location.hash;
	const params = new URLSearchParams(hash.includes('?') ? hash.split('?')[1] : '');
	return {
		widgetType: params.get('type') || 'wc',
		search: params.get('search') || '',
		filter: params.get('status') || 'all',
		contentTypeFilter: params.get('template') || 'all',
	};
};

const WidgetsPage = ({
	allWidgets,
	allSettings,
	onSave,
	saving,
	isPro,
}) => {
	const initialFilters = getFiltersFromHash();
	const [widgetType, setWidgetType] = useState(initialFilters.widgetType);
	const [search, setSearch] = useState(initialFilters.search);
	const [filter, setFilter] = useState(initialFilters.filter);
	const [contentTypeFilter, setContentTypeFilter] = useState(initialFilters.contentTypeFilter);

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

	useEffect(() => {
		const params = new URLSearchParams();
		if (widgetType !== 'wc') params.set('type', widgetType);
		if (search) params.set('search', search);
		if (filter !== 'all') params.set('status', filter);
		if (contentTypeFilter !== 'all') params.set('template', contentTypeFilter);

		const queryString = params.toString();
		const newHash = queryString ? `#widgets?${queryString}` : '#widgets';

		if (window.location.hash !== newHash) {
			window.history.replaceState(null, '', newHash);
		}
	}, [widgetType, search, filter, contentTypeFilter]);

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

	const cardBase =
		'flex flex-col justify-between gap-3 rounded-usk border border-slate-200 bg-white p-4 transition-all duration-200 hover:shadow-usk';

	return (
		<div>
			<div className="mb-5 flex items-center justify-between">
				<h2 className="m-0 text-xl font-bold text-slate-800">
					{currentConfig.title}
				</h2>
				<div className="flex items-center gap-2">
					<span className="rounded-2xl border border-slate-200 bg-white px-3 py-1 text-[13px] text-slate-500">
						{activeCount} / {widgets.filter((w) => w.type === 'checkbox').length}{' '}
						{__('Active', 'ultimate-store-kit')}
					</span>
				</div>
			</div>

			<div className="mb-5 flex flex-wrap items-center gap-3 rounded-usk border border-slate-200 bg-white px-4 py-3">
				<div className="flex flex-[0_0_220px] items-center gap-1.5 rounded-md border border-slate-200 bg-slate-100 px-2.5">
					<span className="dashicons dashicons-search h-4 w-4 text-base text-slate-400"></span>
					<input
						type="text"
						className="w-full border-0 bg-transparent py-1.5 text-[13px] text-slate-700 outline-none placeholder:text-slate-400"
						placeholder={__('Search widgets...', 'ultimate-store-kit')}
						value={search}
						onChange={(e) => setSearch(e.target.value)}
					/>
				</div>

				<div className="flex items-center gap-1.5">
					<label className={selectLabel}>
						{__('Widget Type:', 'ultimate-store-kit')}
					</label>
					<select
						className={selectInput}
						value={widgetType}
						onChange={(e) => setWidgetType(e.target.value)}
					>
						<option value="wc">{__('WooCommerce', 'ultimate-store-kit')}</option>
						<option value="edd">{__('EDD', 'ultimate-store-kit')}</option>
						<option value="other">{__('Other', 'ultimate-store-kit')}</option>
					</select>
				</div>

				<div className="flex items-center gap-1.5">
					<label className={selectLabel}>
						{__('Status:', 'ultimate-store-kit')}
					</label>
					<select
						className={selectInput}
						value={filter}
						onChange={(e) => setFilter(e.target.value)}
					>
						<option value="all">{__('All', 'ultimate-store-kit')}</option>
						<option value="free">{__('Free', 'ultimate-store-kit')}</option>
						<option value="pro">{__('Pro', 'ultimate-store-kit')}</option>
					</select>
				</div>

				{contentTypes.length > 0 && (
					<div className="flex items-center gap-1.5">
						<label className={selectLabel}>
							{__('Template:', 'ultimate-store-kit')}
						</label>
						<select
							className={selectInput}
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

				<div className="ml-auto flex gap-1.5">
					<button
						type="button"
						className={`${btnSm} ${btnOutlineGreen}`}
						onClick={handleActivateAll}
					>
						{__('Activate All', 'ultimate-store-kit')}
					</button>
					<button
						type="button"
						className={`${btnSm} ${btnOutlineRed}`}
						onClick={handleDeactivateAll}
					>
						{__('Deactivate All', 'ultimate-store-kit')}
					</button>
				</div>
			</div>

			<div className="grid grid-cols-4 gap-3">
				{filteredWidgets.length === 0 && (
					<div className="col-span-full py-10 text-center text-sm text-slate-400">
						{__('No widgets found.', 'ultimate-store-kit')}
					</div>
				)}
				{filteredWidgets.map((widget) => {
					const isProWidget = widget.widget_type === 'pro';
					const dependency = widget.dependency || null;
					const hasMissingDependency =
						dependency && (!dependency.isInstalled || !dependency.isActive);
					const isDisabled = (isProWidget && !isPro) || hasMissingDependency;
					const isActive =
						!isDisabled && localSettings[widget.name] === 'on';

					return (
						<div
							key={widget.name}
							className={`${cardBase} ${
								isActive ? 'border-emerald-300 bg-emerald-50' : ''
							} ${isDisabled ? 'opacity-60' : ''}`}
						>
							<div className="flex items-start justify-between gap-2">
								<span className="text-[13px] font-semibold leading-snug text-slate-800">
									{widget.label}
								</span>
								{isProWidget && (
									<span className={proBadge}>
										{__('Pro', 'ultimate-store-kit')}
									</span>
								)}
							</div>
							<div className="flex items-center justify-between">
								<div className="flex gap-2">
									{dependency?.actionUrl && (
										<a
											href={dependency.actionUrl}
											target={dependency.actionType === 'install' ? '_blank' : undefined}
											rel={dependency.actionType === 'install' ? 'noopener noreferrer' : undefined}
											title={dependency.message || dependency.actionLabel}
											className="text-slate-400 transition-colors hover:text-uks-brand"
										>
											<span className="dashicons dashicons-admin-plugins text-base"></span>
										</a>
									)}
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
												className="text-slate-400 transition-colors hover:text-uks-brand"
											>
												<span className="dashicons dashicons-visibility text-base"></span>
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
											className="text-slate-400 transition-colors hover:text-uks-brand"
										>
											<span className="dashicons dashicons-video-alt3 text-base"></span>
										</a>
									)}
								</div>
								<label className={toggleLabel}>
									<input
										type="checkbox"
										className={toggleInput}
										checked={isActive}
										disabled={isDisabled}
										onChange={() =>
											handleToggle(widget.name)
										}
									/>
									<span className={toggleTrack} />
									<span className={toggleKnob} />
								</label>
							</div>
							{hasMissingDependency && dependency?.actionUrl && (
								<div className="text-[13px] leading-relaxed text-slate-500">
									{dependency.message}{' '}
									<a
										href={dependency.actionUrl}
										className="font-semibold text-uks-brand hover:underline"
										target={dependency.actionType === 'install' ? '_blank' : undefined}
										rel={dependency.actionType === 'install' ? 'noopener noreferrer' : undefined}
									>
										{dependency.actionLabel}
									</a>
								</div>
							)}
						</div>
					);
				})}
			</div>

			<div className="mt-6 flex justify-end pt-4">
				<button
					type="button"
					className={`${btnLg} ${btnPrimary}`}
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
