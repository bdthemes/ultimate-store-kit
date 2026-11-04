/**
 * Tab strip attached under the app bar, as in the Element Pack dashboard:
 * primary pages as pill tabs, everything else in a trailing "More" menu.
 *
 * Tabs that don't fit the strip's width move into "More" too (priority-plus):
 * their widths are measured from a hidden copy of the row and the split is
 * recomputed whenever the strip is resized.
 */
import { useState, useEffect, useLayoutEffect, useRef, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { MoreIcon } from '../ui/Icons';

const TAB_BASE =
	'flex shrink-0 cursor-pointer items-center gap-[7px] whitespace-nowrap rounded-full border-0 px-4 py-[11px] text-sm font-bold no-underline transition-all duration-200';
const TAB_ACTIVE = 'bg-gradient-brand text-white shadow-glow hover:text-white';
const TAB_IDLE = 'bg-transparent text-[#52525b] hover:bg-[#f3f5f8] hover:text-[#18181b]';

// Gap between tabs (`gap-1`); must match the rows below.
const TAB_GAP = 4;

const Tab = ({ tab, onClick, expanded, controls, buttonRef, tabIndex }) => {
	const Icon = tab.icon;
	const className = `${TAB_BASE} ${tab.active ? TAB_ACTIVE : TAB_IDLE}`;
	const inner = (
		<>
			{Icon ? <Icon size={17} /> : null}
			{tab.label}
		</>
	);

	if (tab.href) {
		return (
			<a href={tab.href} className={className} tabIndex={tabIndex}>
				{inner}
			</a>
		);
	}

	return (
		<button
			ref={buttonRef}
			type="button"
			onClick={onClick}
			className={className}
			tabIndex={tabIndex}
			aria-current={tab.active ? 'page' : undefined}
			aria-expanded={expanded}
			aria-haspopup={undefined === expanded ? undefined : 'menu'}
			aria-controls={controls}
		>
			{inner}
		</button>
	);
};

const TabStrip = ({ tabs, moreItems = [], onNavigate }) => {
	const [moreOpen, setMoreOpen] = useState(false);
	const wrapRef = useRef(null);
	const moreBtnRef = useRef(null);
	const [menuLeft, setMenuLeft] = useState(16);

	// --- Overflow measurement -------------------------------------------------
	const rowRef = useRef(null);
	const ghostRef = useRef(null);
	const widthsRef = useRef([]);
	const moreWidthRef = useRef(0);
	const [visibleCount, setVisibleCount] = useState(tabs.length);

	const recompute = useCallback(() => {
		const row = rowRef.current;
		const widths = widthsRef.current;
		if (!row || !widths.length) {
			return;
		}

		const styles = window.getComputedStyle(row);
		const available = row.clientWidth - parseFloat(styles.paddingLeft) - parseFloat(styles.paddingRight);

		let all = 0;
		widths.forEach((w, i) => {
			all += w + (i > 0 ? TAB_GAP : 0);
		});

		// Everything fits, and there is no secondary item that needs "More".
		if (all <= available && moreItems.length === 0) {
			setVisibleCount((prev) => (prev === widths.length ? prev : widths.length));
			return;
		}

		const budget = available - moreWidthRef.current - TAB_GAP;
		let used = 0;
		let count = 0;
		for (let i = 0; i < widths.length; i++) {
			const add = widths[i] + (count > 0 ? TAB_GAP : 0);
			if (used + add > budget) {
				break;
			}
			used += add;
			count += 1;
		}

		setVisibleCount((prev) => (prev === count ? prev : count));
	}, [moreItems.length]);

	// Measure after every render: labels or the tab list may have changed.
	useLayoutEffect(() => {
		const ghost = ghostRef.current;
		if (!ghost) {
			return;
		}
		const kids = Array.from(ghost.children);
		const moreEl = kids.pop();
		widthsRef.current = kids.map((el) => el.getBoundingClientRect().width);
		moreWidthRef.current = moreEl ? moreEl.getBoundingClientRect().width : 0;
		recompute();
	});

	useEffect(() => {
		const row = rowRef.current;
		if (!row || typeof window.ResizeObserver === 'undefined') {
			window.addEventListener('resize', recompute);
			return () => window.removeEventListener('resize', recompute);
		}
		const observer = new window.ResizeObserver(() => recompute());
		observer.observe(row);
		return () => observer.disconnect();
	}, [recompute]);

	const shownTabs = tabs.slice(0, visibleCount);
	const menuItems = [...tabs.slice(visibleCount), ...moreItems];

	// --- More menu --------------------------------------------------------------
	useEffect(() => {
		if (!moreOpen) {
			return undefined;
		}
		const onDocClick = (event) => {
			if (wrapRef.current && !wrapRef.current.contains(event.target)) {
				setMoreOpen(false);
			}
		};
		const onKey = (event) => {
			if (event.key === 'Escape') {
				setMoreOpen(false);
				moreBtnRef.current?.focus();
			}
		};
		document.addEventListener('mousedown', onDocClick);
		document.addEventListener('keydown', onKey);
		return () => {
			document.removeEventListener('mousedown', onDocClick);
			document.removeEventListener('keydown', onKey);
		};
	}, [moreOpen]);

	// A tab that moved back into the row leaves an open menu stale.
	useEffect(() => {
		if (menuItems.length === 0) {
			setMoreOpen(false);
		}
	}, [menuItems.length]);

	const go = (item) => {
		setMoreOpen(false);
		if (item.href) {
			window.location.href = item.href;
			return;
		}
		onNavigate(item.key);
	};

	const moreActive = moreOpen || menuItems.some((item) => item.active);
	const moreTab = { key: 'more', label: __('More', 'ultimate-store-kit'), icon: MoreIcon, active: moreActive };

	return (
		<div
			ref={wrapRef}
			className="relative rounded-b-card border-0 border-t border-solid border-[#eef0f3] bg-[#fafbfc]"
		>
			{/* Hidden copy of every tab plus "More", only for measuring widths. */}
			<div aria-hidden="true" className="pointer-events-none absolute inset-x-0 top-0 overflow-hidden">
				<div ref={ghostRef} className="invisible flex w-max gap-1 px-4 py-2">
					{tabs.map((tab) => (
						<Tab key={tab.key} tab={{ ...tab, active: false, href: undefined }} onClick={() => {}} tabIndex={-1} />
					))}
					<Tab tab={{ ...moreTab, active: false }} onClick={() => {}} tabIndex={-1} />
				</div>
			</div>

			<nav
				ref={rowRef}
				className="flex flex-nowrap items-center gap-1 overflow-hidden px-4 py-2"
				aria-label={__('Ultimate Store Kit', 'ultimate-store-kit')}
			>
				{shownTabs.map((tab) => (
					<Tab key={tab.key} tab={tab} onClick={() => go(tab)} />
				))}

				{menuItems.length > 0 ? (
					<Tab
						buttonRef={moreBtnRef}
						tab={moreTab}
						expanded={moreOpen}
						controls="usk-more-menu"
						onClick={() => {
							if (!moreOpen && moreBtnRef.current && wrapRef.current) {
								const btn = moreBtnRef.current.getBoundingClientRect();
								const wrap = wrapRef.current.getBoundingClientRect();
								setMenuLeft(Math.max(8, Math.min(btn.left - wrap.left, wrap.width - 236)));
							}
							setMoreOpen((open) => !open);
						}}
					/>
				) : null}
			</nav>

			{moreOpen && menuItems.length ? (
				<div
					id="usk-more-menu"
					role="menu"
					style={{ left: menuLeft }}
					className="absolute top-full z-50 mt-1 min-w-[228px] animate-usk-pop overflow-hidden rounded-panel border border-solid border-[#e6e6ea] bg-white py-1.5 shadow-pop"
				>
					{menuItems.map((item) => {
						const Icon = item.icon;
						return (
							<button
								key={item.key}
								type="button"
								role="menuitem"
								onClick={() => go(item)}
								aria-current={item.active ? 'page' : undefined}
								className={`box-border flex w-full cursor-pointer items-center gap-[10px] border-0 px-[14px] py-[10px] text-left text-[13.5px] font-bold transition-colors ${
									item.active ? 'bg-[#fff1f2] text-[#e30c1d]' : 'bg-transparent text-[#3f3f46] hover:bg-[#f3f5f8]'
								}`}
							>
								<span className={item.active ? 'text-[#e30c1d]' : 'text-[#6c6c75]'}>
									{Icon ? <Icon size={16} /> : null}
								</span>
								<span className="flex-1">{item.label}</span>
								{item.badge ? (
									<span className="rounded-full bg-[#f4f4f5] px-1.5 py-0.5 text-[10px] font-bold text-[#6d6d74]">{item.badge}</span>
								) : null}
							</button>
						);
					})}
				</div>
			) : null}
		</div>
	);
};

export default TabStrip;
