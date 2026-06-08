import { useState, useMemo, useCallback, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import {
	CheckIcon,
	CloseIcon,
	EyeIcon,
	LinkPluginIcon,
	PlayIcon,
	SearchIcon,
} from '../icons';
import {
	btnLg,
	btnPrimary,
	proBadge,
	selectInput,
	selectLabel,
	Toggle,
} from '../tw';
import { isWidgetEffectivelyOn } from '../utils';

const WidgetsPage = ({
	allWidgets,
	allSettings,
	onSave,
	saving,
	isPro,
	widgetType = 'wc',
}) => {
	const [search, setSearch] = useState('');
	const [filter, setFilter] = useState('all');
	const [contentTypeFilter, setContentTypeFilter] = useState('all');

	const widgetTypeConfig = {
		wc: {
			title: __('WooCommerce Widgets', 'ultimate-store-kit'),
			key: 'ultimate_store_kit_active_modules',
		},
		edd: {
			title: __('Easy Digital Downloads Widgets', 'ultimate-store-kit'),
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
		setSearch('');
		setFilter('all');
		setContentTypeFilter('all');
	}, [widgetType]);

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
				const dep = w.dependency;
				if (dep && (!dep.isInstalled || !dep.isActive)) return;
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

	const activeCount = useMemo(() => {
		return widgets.filter(
			(w) =>
				w.type === 'checkbox' &&
				isWidgetEffectivelyOn(w, localSettings[w.name], isPro)
		).length;
	}, [widgets, localSettings, isPro]);

	const cardBase =
		'flex flex-col justify-between gap-3 rounded-lg border border-solid border-gray-200 p-4';

	const toolbarControl = 'h-9 min-h-9 py-0 text-[13px] leading-none';
	const toolbarBtn =
		'inline-flex h-9 min-h-9 shrink-0 cursor-pointer items-center gap-1.5 rounded-md border px-3 py-0 text-[13px] font-semibold leading-none no-underline transition-all duration-200';

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
					<SearchIcon className="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 block text-gray-400" />
					<input
						type="text"
						className={`${toolbarControl} block w-full rounded-md border border-solid border-gray-200 bg-transparent pr-10 pl-3 text-slate-700 placeholder:text-gray-500 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-uks-brand/25 sm:w-48`}
						placeholder={__('Search widgets...', 'ultimate-store-kit')}
						value={search}
						onChange={(e) => setSearch(e.target.value)}
					/>
				</div>

				<div className="flex items-center gap-1.5">
					<label className={selectLabel}>
						{__('Status:', 'ultimate-store-kit')}
					</label>
					<select
						className={`${selectInput} ${toolbarControl}`}
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
							className={`${selectInput} ${toolbarControl}`}
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
					className={`${toolbarBtn} ${
						activeCount > 0
							? '!bg-uks-brand !text-white hover:!bg-uks-brand-dark border-none'
							: '!border !border-uks-brand/25 bg-uks-brand/5 text-uks-brand hover:bg-uks-brand/10 hover:text-uks-brand-dark'
					} focus:outline-none focus:ring-2 focus:ring-uks-brand focus:ring-offset-2 focus:ring-offset-white`}
					onClick={handleActivateAll}
				>
					<CheckIcon className="h-3.5 w-3.5" />
					{__('Activate All', 'ultimate-store-kit')}
				</button>
				<button
					type="button"
					className={`${toolbarBtn} ${
						activeCount === 0
							? '!bg-uks-brand !text-white hover:!bg-uks-brand-dark border-none'
							: '!border !border-uks-brand/25 bg-uks-brand/5 text-uks-brand hover:bg-uks-brand/10 hover:text-uks-brand-dark'
					} focus:outline-none focus:ring-2 focus:ring-uks-brand focus:ring-offset-2 focus:ring-offset-white`}
					onClick={handleDeactivateAll}
				>
					<CloseIcon className="h-3.5 w-3.5" />
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
					const isActive = isWidgetEffectivelyOn(
						widget,
						localSettings[widget.name],
						isPro
					);

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
											<LinkPluginIcon className="w-4 h-4 block" />

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
												<EyeIcon className="w-4 h-4 block" />

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
											<PlayIcon className="w-4 h-4 block" />

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
