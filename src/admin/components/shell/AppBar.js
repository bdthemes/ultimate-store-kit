/**
 * App bar of the Element Pack-style shell: logo, PRO tag and version on the
 * left; licence status, the ⌘K search, Docs and one primary action on the
 * right.
 */
import { useState, useEffect, useMemo, useRef } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { applyFilters } from '@wordpress/hooks';
import { UskLogo } from '../../icons';
import { BookIcon, SearchIcon, TemplateIcon, ZapIcon, ArrowRightIcon } from '../ui/Icons';
import { ProTag } from '../ui/Primitives';

const DOCS_URL = 'https://bdthemes.com/knowledge-base/ultimate-store-kit/';
const PRO_URL = 'https://storekit.pro/pricing/';

const LicensePill = ({ isPro, isProPluginActive }) => {
	if (isProPluginActive && isPro) {
		return (
			<span className="flex items-center gap-[7px] rounded-full border border-solid border-[#c6f0d4] bg-[#ecfdf3] px-[15px] py-[9px] text-[13px] font-bold text-[#15803d] max-lg:hidden">
				<span className="h-2 w-2 rounded-full bg-[#22c55e] shadow-[0_0_0_3px_rgba(34,197,94,.2)]" />
				{__('License active', 'ultimate-store-kit')}
			</span>
		);
	}

	if (isProPluginActive) {
		return (
			<span className="flex items-center gap-[7px] rounded-full border border-solid border-[#fde2b8] bg-[#fff7ed] px-[15px] py-[9px] text-[13px] font-bold text-[#b45309] max-lg:hidden">
				<span className="h-2 w-2 rounded-full bg-[#f59e0b]" />
				{__('License inactive', 'ultimate-store-kit')}
			</span>
		);
	}

	return (
		<span className="flex items-center gap-[7px] rounded-full border border-solid border-[#e6e6ea] bg-[#f4f5f7] px-[15px] py-[9px] text-[13px] font-bold text-[#52525b] max-lg:hidden">
			<span className="h-2 w-2 rounded-full bg-[#a1a1aa]" />
			{__('Free version', 'ultimate-store-kit')}
		</span>
	);
};

/**
 * ⌘K palette over the dashboard's pages, widgets and modules.
 */
const SearchPalette = ({ items, onClose, onSelect }) => {
	const [query, setQuery] = useState('');
	const [active, setActive] = useState(0);
	const inputRef = useRef(null);

	const results = useMemo(() => {
		const q = query.trim().toLowerCase();
		const list = q
			? items.filter((item) => `${item.label} ${item.group}`.toLowerCase().includes(q))
			: items.filter((item) => item.group !== __('Widgets', 'ultimate-store-kit'));
		return list.slice(0, 12);
	}, [items, query]);

	useEffect(() => {
		inputRef.current?.focus();
	}, []);

	useEffect(() => {
		setActive(0);
	}, [query]);

	const onKeyDown = (event) => {
		if (event.key === 'Escape') {
			event.preventDefault();
			onClose();
		} else if (event.key === 'ArrowDown') {
			event.preventDefault();
			setActive((i) => Math.min(i + 1, results.length - 1));
		} else if (event.key === 'ArrowUp') {
			event.preventDefault();
			setActive((i) => Math.max(i - 1, 0));
		} else if (event.key === 'Enter' && results[active]) {
			event.preventDefault();
			onSelect(results[active]);
		}
	};

	return (
		<div
			className="fixed inset-0 z-[100000] flex items-start justify-center bg-[rgba(15,17,21,.45)] px-4 pt-[12vh]"
			onMouseDown={(event) => event.target === event.currentTarget && onClose()}
		>
			<div
				role="dialog"
				aria-modal="true"
				aria-label={__('Search', 'ultimate-store-kit')}
				className="w-full max-w-[560px] animate-usk-pop overflow-hidden rounded-card border border-solid border-[#e6e6ea] bg-white shadow-pop"
			>
				<div className="flex items-center gap-3 border-0 border-b border-solid border-[#eef0f3] px-[18px] py-[14px] text-[#6c6c75]">
					<SearchIcon size={18} />
					<input
						ref={inputRef}
						type="text"
						value={query}
						onChange={(event) => setQuery(event.target.value)}
						onKeyDown={onKeyDown}
						placeholder={__('Search widgets, modules and pages…', 'ultimate-store-kit')}
						className="!m-0 w-full !border-0 !bg-transparent !p-0 text-[15px] text-[#0f1115] !shadow-none !outline-none"
						role="combobox"
						aria-expanded="true"
						aria-controls="usk-search-results"
						aria-activedescendant={results[active] ? `usk-search-${active}` : undefined}
					/>
					<kbd className="rounded-md border border-solid border-[#e6e6ea] px-1.5 py-0.5 text-[11px] font-semibold text-[#6c6c75]">esc</kbd>
				</div>
				<ul id="usk-search-results" role="listbox" className="m-0 max-h-[360px] list-none overflow-y-auto p-2">
					{results.length === 0 ? (
						<li className="px-3 py-6 text-center text-[13px] text-[#6c6c75]">
							{__('Nothing found.', 'ultimate-store-kit')}
						</li>
					) : (
						results.map((item, index) => (
							<li
								key={`${item.group}-${item.id}`}
								id={`usk-search-${index}`}
								role="option"
								aria-selected={index === active}
								onMouseEnter={() => setActive(index)}
								onMouseDown={(event) => {
									event.preventDefault();
									onSelect(item);
								}}
								className={`m-0 flex cursor-pointer items-center justify-between gap-3 rounded-[10px] px-3 py-[10px] text-[13.5px] font-semibold ${
									index === active ? 'bg-[#fff1f2] text-[#e30c1d]' : 'text-[#27272a]'
								}`}
							>
								<span>{item.label}</span>
								<span className="flex items-center gap-2 text-[11.5px] font-medium text-[#8a8a93]">
									{item.group}
									<ArrowRightIcon size={13} />
								</span>
							</li>
						))
					)}
				</ul>
			</div>
		</div>
	);
};

const AppBar = ({ version, isPro, isProPluginActive, templateBuilderUrl, searchItems = [], onSearchSelect }) => {
	const [searchOpen, setSearchOpen] = useState(false);
	const isMac = typeof navigator !== 'undefined' && /Mac|iPhone|iPad/.test(navigator.platform || '');

	useEffect(() => {
		// Capture phase on window, so WordPress' own ⌘K command palette does
		// not open on top of this one while the dashboard is shown.
		const onKey = (event) => {
			if ((event.metaKey || event.ctrlKey) && (event.key || '').toLowerCase() === 'k') {
				event.preventDefault();
				event.stopImmediatePropagation();
				setSearchOpen((open) => !open);
			}
		};
		window.addEventListener('keydown', onKey, true);
		return () => window.removeEventListener('keydown', onKey, true);
	}, []);

	const HeaderExtra = applyFilters('usk.admin.headerExtra', null);
	const proPages = applyFilters('usk.admin.pages', {});
	const showGetPro = !isPro && !proPages.license;

	const pillBtn =
		'inline-flex items-center gap-[6px] rounded-full border-[1.5px] border-solid border-[#e2e2e6] bg-white px-[17px] py-[10px] text-[13.5px] font-bold text-[#27272a] no-underline transition-colors hover:border-[#e30c1d] hover:text-[#e30c1d]';
	const ctaBtn =
		'inline-flex items-center gap-[7px] rounded-full bg-gradient-brand px-[22px] py-[11px] text-[13.5px] font-extrabold text-white no-underline shadow-glow transition-all duration-200 hover:-translate-y-px hover:text-white hover:shadow-glow-lg max-[640px]:px-[15px]';

	return (
		<div className="flex min-h-[80px] flex-wrap items-center justify-between gap-5 px-[26px] py-[18px] max-[900px]:gap-3 max-[900px]:px-[15px] max-[900px]:py-[13px]">
			<div className="flex min-w-0 items-center gap-3">
				<UskLogo className="block h-9 w-9" />
				<span className="whitespace-nowrap text-[19px] font-extrabold tracking-[-.02em] text-[#0f1115] max-[480px]:text-[16px]">
					{__('Ultimate Store Kit', 'ultimate-store-kit')}
				</span>
				{isPro ? <ProTag /> : null}
				{version ? (
					<span className="text-[12.5px] font-bold text-[#6c6c75]">v{version}</span>
				) : null}
			</div>

			<div className="flex flex-wrap items-center gap-[10px]">
				<LicensePill isPro={isPro} isProPluginActive={isProPluginActive} />

				<button
					type="button"
					onClick={() => setSearchOpen(true)}
					className="flex cursor-pointer items-center gap-2 rounded-full border border-solid border-[#e6e6ea] bg-[#f4f5f7] py-[9px] pl-[14px] pr-[9px] text-[13px] font-semibold text-[#6c6c75] transition-colors hover:border-[#e30c1d] hover:text-[#e30c1d] max-md:hidden"
					aria-label={__('Search', 'ultimate-store-kit')}
				>
					<SearchIcon size={15} />
					{__('Search', 'ultimate-store-kit')}
					<span className="flex gap-1">
						<kbd className="rounded-md border border-solid border-[#e2e2e6] bg-white px-[6px] text-[11px] font-semibold">{isMac ? '⌘' : 'Ctrl'}</kbd>
						<kbd className="rounded-md border border-solid border-[#e2e2e6] bg-white px-[6px] text-[11px] font-semibold">K</kbd>
					</span>
				</button>

				{HeaderExtra ? <HeaderExtra /> : null}

				<a href={DOCS_URL} target="_blank" rel="noopener noreferrer" className={`${pillBtn} max-[640px]:hidden`}>
					<BookIcon size={14} />
					{__('Docs', 'ultimate-store-kit')}
				</a>

				{showGetPro ? (
					<a href={PRO_URL} target="_blank" rel="noopener noreferrer" className={ctaBtn}>
						<ZapIcon size={14} />
						{__('Get Pro', 'ultimate-store-kit')}
					</a>
				) : (
					<a href={templateBuilderUrl} className={ctaBtn}>
						<TemplateIcon size={14} />
						{__('Template Builder', 'ultimate-store-kit')}
					</a>
				)}
			</div>

			{searchOpen ? (
				<SearchPalette
					items={searchItems}
					onClose={() => setSearchOpen(false)}
					onSelect={(item) => {
						setSearchOpen(false);
						onSearchSelect?.(item);
					}}
				/>
			) : null}
		</div>
	);
};

export default AppBar;
