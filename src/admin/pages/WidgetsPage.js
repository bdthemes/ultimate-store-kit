/**
 * Widgets, laid out like Element Pack's: heading with bulk actions, a toolbar
 * (search, WooCommerce/EDD/Others switch, Free/Pro/New chips), a three-column
 * card grid and a sticky save bar while there are unsaved changes.
 */
import { useState, useMemo, useCallback, useEffect } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import { Toggle } from '../tw';
import { isWidgetEffectivelyOn } from '../utils';
import { SearchIcon, EyeIcon, PlayIcon, PlugIcon, CheckIcon, XIcon, WidgetsIcon } from '../components/ui/Icons';
import { ProTag, Pill } from '../components/ui/Primitives';

const SECTION_KEYS = {
	wc: 'ultimate_store_kit_active_modules',
	edd: 'ultimate_store_kit_edd_modules',
	other: 'ultimate_store_kit_general_modules',
};

const PAGE_FOR_TYPE = {
	wc: 'woocommerce-widgets',
	edd: 'edd-widgets',
	other: 'other-widgets',
};

const searchFromHash = () => {
	const query = window.location.hash.split('?')[1] || '';
	try {
		return new URLSearchParams(query).get('search') || '';
	} catch (e) {
		return '';
	}
};

const initialValues = (allWidgets, allSettings) => {
	const initial = {};
	Object.values(SECTION_KEYS).forEach((sectionKey) => {
		const sectionSettings = allSettings[sectionKey] || {};
		(allWidgets[sectionKey] || []).forEach((w) => {
			if (w.type !== 'checkbox') return;
			initial[w.name] = sectionSettings[w.name] !== undefined ? sectionSettings[w.name] : w.default || 'off';
		});
	});
	return initial;
};

const linkClass =
	'inline-flex items-center gap-1 text-[11.5px] font-semibold text-[#8a8a93] no-underline transition-colors hover:text-[#e30c1d]';

const WidgetsPage = ({ allWidgets, allSettings, onSave, saving, isPro, widgetType = 'wc', onNavigate }) => {
	const [search, setSearch] = useState(searchFromHash);
	const [filter, setFilter] = useState('all');
	const [contentTypeFilter, setContentTypeFilter] = useState('all');
	const [localSettings, setLocalSettings] = useState(() => initialValues(allWidgets, allSettings));

	const sectionKey = SECTION_KEYS[widgetType] || SECTION_KEYS.wc;
	const widgets = useMemo(() => (allWidgets[sectionKey] || []).filter((w) => w.type === 'checkbox'), [allWidgets, sectionKey]);

	// Saved values (re-read after a save) to tell what changed.
	const savedValues = useMemo(() => initialValues(allWidgets, allSettings), [allWidgets, allSettings]);

	useEffect(() => {
		setSearch(searchFromHash());
		setFilter('all');
		setContentTypeFilter('all');
	}, [widgetType]);

	useEffect(() => {
		const onHash = () => setSearch(searchFromHash());
		window.addEventListener('hashchange', onHash);
		return () => window.removeEventListener('hashchange', onHash);
	}, []);

	const isLocked = useCallback(
		(w) => {
			const dep = w.dependency;
			return (w.widget_type === 'pro' && !isPro) || (dep && (!dep.isInstalled || !dep.isActive));
		},
		[isPro]
	);

	const contentTypes = useMemo(() => {
		const types = new Set();
		widgets.forEach((w) => {
			(w.content_type || '').split(' ').forEach((t) => {
				if (t && !['woocommerce', 'edd', 'new', 'others'].includes(t)) {
					types.add(t);
				}
			});
		});
		return Array.from(types);
	}, [widgets]);

	const isNew = (w) => (w.content_type || '').split(' ').includes('new');

	const counts = useMemo(
		() => ({
			all: widgets.length,
			free: widgets.filter((w) => w.widget_type !== 'pro').length,
			pro: widgets.filter((w) => w.widget_type === 'pro').length,
			new: widgets.filter(isNew).length,
		}),
		[widgets]
	);

	const filteredWidgets = useMemo(
		() =>
			widgets.filter((w) => {
				if (search && !w.label.toLowerCase().includes(search.toLowerCase())) return false;
				if (filter === 'free' && w.widget_type === 'pro') return false;
				if (filter === 'pro' && w.widget_type !== 'pro') return false;
				if (filter === 'new' && !isNew(w)) return false;
				if (contentTypeFilter !== 'all' && !(w.content_type || '').split(' ').includes(contentTypeFilter)) return false;
				return true;
			}),
		[widgets, search, filter, contentTypeFilter]
	);

	const activeCount = widgets.filter((w) => isWidgetEffectivelyOn(w, localSettings[w.name], isPro)).length;

	const dirtyNames = widgets.filter((w) => localSettings[w.name] !== savedValues[w.name]).map((w) => w.name);

	const setAll = (value) => {
		setLocalSettings((prev) => {
			const next = { ...prev };
			filteredWidgets.forEach((w) => {
				if (!isLocked(w)) {
					next[w.name] = value;
				}
			});
			return next;
		});
	};

	const handleSave = () => {
		const current = {};
		widgets.forEach((w) => {
			if (localSettings[w.name] !== undefined) {
				current[w.name] = localSettings[w.name];
			}
		});
		onSave(sectionKey, current);
	};

	const discard = () => {
		setLocalSettings((prev) => {
			const next = { ...prev };
			widgets.forEach((w) => {
				next[w.name] = savedValues[w.name];
			});
			return next;
		});
	};

	const categories = [
		{ type: 'wc', label: __('WooCommerce', 'ultimate-store-kit') },
		{ type: 'edd', label: __('EDD', 'ultimate-store-kit') },
		{ type: 'other', label: __('Others', 'ultimate-store-kit') },
	];

	const chips = [
		{ key: 'all', label: __('All', 'ultimate-store-kit') },
		{ key: 'new', label: __('New', 'ultimate-store-kit') },
		{ key: 'free', label: __('Free', 'ultimate-store-kit') },
		{ key: 'pro', label: __('Pro', 'ultimate-store-kit') },
	];

	const pillBtn =
		'inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-solid border-[#e2e2e6] bg-white px-4 py-2 text-[13px] font-bold text-[#27272a] transition-colors hover:border-[#e30c1d] hover:text-[#e30c1d]';

	return (
		<div className={dirtyNames.length ? 'pb-20' : ''}>
			<div className="mb-[18px] flex flex-wrap items-end justify-between gap-3">
				<div>
					<h1 className="m-0 text-[26px] font-extrabold tracking-[-.02em] text-[#0f1115]">{__('Widgets', 'ultimate-store-kit')}</h1>
					<p className="m-0 mt-1.5 text-[13.5px] text-[#6c6c75]">
						{sprintf(
							/* translators: 1: enabled widgets, 2: all widgets in this category. */
							__('%1$d of %2$d enabled - disable unused widgets for faster pages.', 'ultimate-store-kit'),
							activeCount,
							widgets.length
						)}
					</p>
				</div>
				<div className="flex flex-wrap items-center gap-2">
					<span className="inline-flex items-center gap-[7px] rounded-full border border-solid border-[#c6f0d4] bg-[#ecfdf3] px-3 py-[7px] text-[12.5px] font-bold text-[#15803d]">
						<span className="h-2 w-2 rounded-full bg-[#22c55e]" />
						{sprintf(
							/* translators: 1: enabled, 2: total. */
							__('%1$d of %2$d active', 'ultimate-store-kit'),
							activeCount,
							widgets.length
						)}
					</span>
					<button type="button" className={pillBtn} onClick={() => setAll('on')}>
						<CheckIcon size={14} />
						{__('Enable all', 'ultimate-store-kit')}
					</button>
					<button type="button" className={pillBtn} onClick={() => setAll('off')}>
						<XIcon size={14} />
						{__('Disable all', 'ultimate-store-kit')}
					</button>
				</div>
			</div>

			<div className="mb-[14px] flex flex-wrap items-center justify-between gap-3 rounded-card border border-solid border-[#e9e9ed] bg-white px-[14px] py-3">
				<div className="flex flex-wrap items-center gap-3">
					<label className="relative flex w-[260px] max-w-full items-center">
						<span className="sr-only">{__('Search widgets', 'ultimate-store-kit')}</span>
						<span className="pointer-events-none absolute left-3 text-[#8a8a93]">
							<SearchIcon size={15} />
						</span>
						<input
							type="search"
							value={search}
							onChange={(event) => setSearch(event.target.value)}
							placeholder={__('Search widgets…', 'ultimate-store-kit')}
							className="!m-0 box-border w-full !rounded-full !border !border-solid !border-[#e6e6ea] !bg-[#fafbfc] !py-2 !pl-9 !pr-3 text-[13.5px] !shadow-none focus:!border-[#e30c1d]"
						/>
					</label>

					<div className="flex items-center gap-1 rounded-full bg-[#f4f5f7] p-1" role="group" aria-label={__('Widget category', 'ultimate-store-kit')}>
						{categories.map((cat) => {
							const total = (allWidgets[SECTION_KEYS[cat.type]] || []).filter((w) => w.type === 'checkbox').length;
							const active = cat.type === widgetType;
							return (
								<button
									key={cat.type}
									type="button"
									aria-pressed={active}
									onClick={() => onNavigate && onNavigate(PAGE_FOR_TYPE[cat.type])}
									className={`cursor-pointer rounded-full border-0 px-3 py-1.5 text-[12.5px] font-bold transition-colors ${
										active ? 'bg-white text-[#0f1115] shadow-[0_1px_3px_rgba(0,0,0,.12)]' : 'bg-transparent text-[#52525b] hover:text-[#18181b]'
									}`}
								>
									{cat.label} <span className="text-[#8a8a93]">{total}</span>
								</button>
							);
						})}
					</div>

					{contentTypes.length > 0 ? (
						<select
							value={contentTypeFilter}
							onChange={(event) => setContentTypeFilter(event.target.value)}
							className="!m-0 !rounded-full !border !border-solid !border-[#e6e6ea] !bg-white !py-1.5 !pl-3 !pr-8 text-[12.5px] font-semibold !text-[#3f3f46] !shadow-none"
							aria-label={__('Template type', 'ultimate-store-kit')}
						>
							<option value="all">{__('All templates', 'ultimate-store-kit')}</option>
							{contentTypes.map((type) => (
								<option key={type} value={type}>
									{type.charAt(0).toUpperCase() + type.slice(1)}
								</option>
							))}
						</select>
					) : null}
				</div>

				<div className="flex items-center gap-1 rounded-full bg-[#f4f5f7] p-1" role="group" aria-label={__('Filter widgets', 'ultimate-store-kit')}>
					{chips.map((chip) => (
						<button
							key={chip.key}
							type="button"
							onClick={() => setFilter(chip.key)}
							aria-pressed={filter === chip.key}
							className={`cursor-pointer rounded-full border-0 px-3 py-1.5 text-[12.5px] font-bold transition-colors ${
								filter === chip.key ? 'bg-gradient-brand text-white shadow-glow' : 'bg-transparent text-[#52525b] hover:text-[#18181b]'
							}`}
						>
							{chip.label} <span className={filter === chip.key ? 'opacity-80' : 'text-[#8a8a93]'}>{counts[chip.key]}</span>
						</button>
					))}
				</div>
			</div>

			{filteredWidgets.length === 0 ? (
				<div className="rounded-card border border-solid border-[#e9e9ed] bg-white px-6 py-14 text-center text-[13.5px] text-[#6c6c75]">
					{__('No widgets found.', 'ultimate-store-kit')}
				</div>
			) : (
				<div className="grid grid-cols-3 gap-[10px] max-[1180px]:grid-cols-2 max-[700px]:grid-cols-1">
					{filteredWidgets.map((widget) => {
						const dependency = widget.dependency || null;
						const missingDependency = dependency && (!dependency.isInstalled || !dependency.isActive);
						const locked = isLocked(widget);
						const isActive = isWidgetEffectivelyOn(widget, localSettings[widget.name], isPro);
						const changed = localSettings[widget.name] !== savedValues[widget.name];

						return (
							<div
								key={widget.name}
								className={`flex items-center gap-3 rounded-panel border border-solid bg-white px-[14px] py-3 transition-colors ${
									changed ? 'border-[#fbc8cd] bg-[#fffbfb]' : 'border-[#e9e9ed] hover:border-[#d4d4dc]'
								}`}
							>
								<span
									className={`grid h-10 w-10 shrink-0 place-items-center rounded-tile ${isActive ? 'bg-[#fff1f2] text-[#e30c1d]' : 'bg-[#f4f4f5] text-[#8a8a93]'}`}
									aria-hidden="true"
								>
									<i className={`usk-icon-${widget.name} text-[18px] leading-none`} />
								</span>
								<span className="min-w-0 flex-1">
									<span className={`block truncate text-[13.5px] font-bold ${locked ? 'text-[#8a8a93]' : 'text-[#0f1115]'}`}>{widget.label}</span>
									<span className="mt-1 flex flex-wrap items-center gap-x-2.5 gap-y-1">
										{missingDependency && dependency?.actionUrl ? (
											<a
												href={dependency.actionUrl}
												target={dependency.actionType === 'install' ? '_blank' : undefined}
												rel={dependency.actionType === 'install' ? 'noopener noreferrer' : undefined}
												title={dependency.message}
												className={`${linkClass} !text-[#b45309]`}
											>
												<PlugIcon size={12} />
												{dependency.actionLabel || __('Install', 'ultimate-store-kit')}
											</a>
										) : null}
										{widget.demo_url && !widget.demo_url.startsWith('#') ? (
											<a href={widget.demo_url} target="_blank" rel="noopener noreferrer" className={linkClass}>
												<EyeIcon size={12} />
												{__('Demo', 'ultimate-store-kit')}
											</a>
										) : null}
										{widget.video_url ? (
											<a href={widget.video_url} target="_blank" rel="noopener noreferrer" className={linkClass}>
												<PlayIcon size={12} />
												{__('Video', 'ultimate-store-kit')}
											</a>
										) : null}
									</span>
								</span>
								<span className="flex shrink-0 items-center gap-2">
									{isNew(widget) ? <Pill tone="rose">{__('NEW', 'ultimate-store-kit')}</Pill> : null}
									{widget.widget_type === 'pro' ? <ProTag /> : null}
									<span title={locked ? (missingDependency ? dependency?.message : __('Available in Pro', 'ultimate-store-kit')) : undefined}>
										<Toggle
											checked={isActive}
											disabled={locked}
											onChange={() =>
												setLocalSettings((prev) => ({
													...prev,
													[widget.name]: prev[widget.name] === 'on' ? 'off' : 'on',
												}))
											}
										/>
									</span>
								</span>
							</div>
						);
					})}
				</div>
			)}

			{dirtyNames.length ? (
				<div className="fixed bottom-5 left-1/2 z-[9990] box-border flex w-[min(640px,calc(100vw-32px))] -translate-x-1/2 animate-usk-pop items-center justify-between gap-3 rounded-full border border-solid border-[#e6e6ea] bg-white py-2 pl-5 pr-2 shadow-pop">
					<span className="flex items-center gap-2 text-[13.5px] font-bold text-[#0f1115]">
						<span className="text-[#e30c1d]">
							<WidgetsIcon size={16} />
						</span>
						{sprintf(
							/* translators: %d: number of changed widgets. */
							__('%d unsaved change(s)', 'ultimate-store-kit'),
							dirtyNames.length
						)}
					</span>
					<span className="flex items-center gap-2">
						<button type="button" onClick={discard} className="cursor-pointer rounded-full border-0 bg-transparent px-4 py-2 text-[13px] font-bold text-[#52525b] hover:text-[#0f1115]">
							{__('Discard', 'ultimate-store-kit')}
						</button>
						<button
							type="button"
							onClick={handleSave}
							disabled={saving}
							className="cursor-pointer rounded-full border-0 bg-gradient-brand px-5 py-2.5 text-[13px] font-extrabold text-white shadow-glow disabled:cursor-wait disabled:opacity-70"
						>
							{saving ? __('Saving…', 'ultimate-store-kit') : __('Save changes', 'ultimate-store-kit')}
						</button>
					</span>
				</div>
			) : null}
		</div>
	);
};

export default WidgetsPage;
