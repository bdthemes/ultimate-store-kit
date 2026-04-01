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
	Toggle,
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
		'flex flex-col justify-between gap-3 rounded-lg border border-solid border-gray-200 p-4';

	return (
		<div>
		<div className="mb-5 flex flex-wrap items-center justify-between gap-2">
			<h2 className="m-0 text-xl font-bold text-slate-800">
				{currentConfig.title}
			</h2>
			<span className="rounded-2xl border border-slate-200 bg-white px-3 py-1 text-[13px] text-slate-500">
				{activeCount} / {widgets.filter((w) => w.type === 'checkbox').length}{' '}
				{__('Active', 'ultimate-store-kit')}
			</span>
		</div>

		<div className="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-solid border-gray-100 bg-white px-4 py-3">
			{/* Filters group — wraps on small screens */}
			<div className="flex flex-wrap items-center gap-3">
				<div className="relative">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						width={24}
						height={24}
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						strokeWidth={2}
						strokeLinecap="round"
						strokeLinejoin="round"
						className="absolute right-3 top-3 h-4 w-4 block text-gray-400"
					>
						<path d="m21 21-4.34-4.34" />
						<circle cx={11} cy={11} r={8} />
					</svg>
					<input
						type="text"
						className="block w-full rounded-md border border-solid border-gray-200 bg-transparent py-2.5 pr-10 pl-3 text-sm text-slate-700 placeholder:text-gray-500 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand/25 sm:w-48"
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
			</div>

			{/* Action buttons — always pinned to the right, never wrap */}
			<div className="flex flex-wrap items-center gap-1.5">
				<button
					type="button"
					className={`${btnSm} !rounded-lg !bg-uks-brand !text-white hover:!bg-uks-brand-dark focus:outline-none focus:ring-2 focus:ring-uks-brand focus:ring-offset-2 focus:ring-offset-white border-none`}
					onClick={handleActivateAll}
				>
					<svg
						className="h-4 w-4"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						strokeWidth="2"
						strokeLinecap="round"
						strokeLinejoin="round"
						aria-hidden="true"
					>
						<path d="M20 6 9 17l-5-5" />
					</svg>
					{__('Activate All', 'ultimate-store-kit')}
				</button>
				<button
					type="button"
					className={`${btnSm} !rounded-lg !border !border-uks-brand/25 bg-uks-brand/5 text-uks-brand hover:bg-uks-brand/10 hover:text-uks-brand-dark focus:outline-none focus:ring-2 focus:ring-uks-brand focus:ring-offset-2 focus:ring-offset-white`}
					onClick={handleDeactivateAll}
				>
					<svg
						className="h-4 w-4"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						strokeWidth="2"
						strokeLinecap="round"
						strokeLinejoin="round"
						aria-hidden="true"
					>
						<path d="M18 6 6 18" />
						<path d="M6 6l12 12" />
					</svg>
					{__('Deactivate All', 'ultimate-store-kit')}
				</button>
			</div>
		</div>

			<div className="grid grid-cols-1 gap-3 rounded-lg border border-solid border-gray-100 bg-white p-5 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
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
							className={`${cardBase} ${isActive ? 'border-emerald-300' : ''
								} ${isDisabled ? 'opacity-60 cursor-not-allowed bg-slate-100' : ''}`}
						>
							<div className="flex items-start justify-between gap-2">
								<span className="text-base font-semibold leading-snug text-slate-800">
									{widget.label}
								</span>
								{isProWidget && (
									<span className={proBadge}>
										{__('Pro', 'ultimate-store-kit')}
									</span>
								)}
							</div>
							<div className="flex items-center justify-between">
								<div className="flex gap-2 items-center">
									{dependency?.actionUrl && (
										<a

											href={dependency.actionUrl}
											target={dependency.actionType === 'install' ? '_blank' : undefined}
											rel={dependency.actionType === 'install' ? 'noopener noreferrer' : undefined}
											title={dependency.message || dependency.actionLabel}
											className="text-gray-400 transition-colors hover:text-uks-brand flex items-center gap-1 decoration-none"
											style={{
												textDecoration: 'none',
											}}
										>
											<svg
												xmlns="http://www.w3.org/2000/svg"
												width={24}
												height={24}
												viewBox="0 0 24 24"
												fill="none"
												stroke="currentColor"
												strokeWidth={2}
												strokeLinecap="round"
												strokeLinejoin="round"
												className="w-4 h-4 block"
											>
												<path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z" />
												<path d="m2 22 3-3" />
												<path d="M7.5 13.5 10 11" />
												<path d="M10.5 16.5 13 14" />
												<path d="m18 3-4 4h6l-4 4" />
											</svg>

											{__('Install', 'ultimate-store-kit')}
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
												className="text-gray-400 transition-colors hover:text-uks-brand flex items-center gap-1 decoration-none"
												style={{
													textDecoration: 'none',
												}}
											>
												<svg
													xmlns="http://www.w3.org/2000/svg"
													width={24}
													height={24}
													viewBox="0 0 24 24"
													fill="none"
													stroke="currentColor"
													strokeWidth={2}
													strokeLinecap="round"
													strokeLinejoin="round"
													className="w-4 h-4 block"
												>
													<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
													<circle cx={12} cy={12} r={3} />
												</svg>

												{__('Demo', 'ultimate-store-kit')}
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
											className="text-gray-400 transition-colors hover:text-uks-brand flex items-center gap-1 decoration-none"

												style={{
													textDecoration: 'none',
												}}
										>
											<svg
												xmlns="http://www.w3.org/2000/svg"
												width={24}
												height={24}
												viewBox="0 0 24 24"
												fill="none"
												stroke="currentColor"
												strokeWidth={2}
												strokeLinecap="round"
												strokeLinejoin="round"
												className="w-4 h-4 block"
											>
												<path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z" />
											</svg>

											{__('Video', 'ultimate-store-kit')}
										</a>
									)}
								</div>
								<Toggle
									checked={isActive}
									disabled={isDisabled}
									onChange={() =>
										handleToggle(widget.name)
									}
								/>
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
