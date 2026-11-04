/**
 * Dashboard, laid out like Element Pack's: welcome line, stat cards, a
 * widget-health strip, then quick actions, Pro extras and recent releases on
 * the left with a promo, system status and resources on the right.
 */
import { useMemo } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import { applyFilters } from '@wordpress/hooks';
import { isWidgetEffectivelyOn, getModuleInfo } from '../utils';
import {
	WidgetsIcon,
	ModulesIcon,
	TemplateIcon,
	KeyIcon,
	ZapIcon,
	BookIcon,
	HeadsetIcon,
	ActivityIcon,
	CartIcon,
	DownloadIcon,
	LayersIcon,
	ExternalIcon,
	ChevronRightIcon,
	MessageIcon,
	SparkIcon,
	GaugeIcon,
	ArrowRightIcon,
} from '../components/ui/Icons';
import { Card, IconTile, ProgressBar, Pill } from '../components/ui/Primitives';

const adminData = window.ultimateStoreKitAdminData || {};

const SECTIONS = {
	wc: 'ultimate_store_kit_active_modules',
	edd: 'ultimate_store_kit_edd_modules',
	other: 'ultimate_store_kit_general_modules',
};

const countWidgets = (widgets, settings, isPro) => {
	let active = 0;
	let total = 0;
	(widgets || []).forEach((w) => {
		if (w.type !== 'checkbox') return;
		total++;
		if (isWidgetEffectivelyOn(w, (settings || {})[w.name], isPro)) {
			active++;
		}
	});
	return { active, total, percent: total ? Math.round((active / total) * 100) : 0 };
};

const StatCard = ({ icon, accent, value, label, pill, pillTone }) => (
	<div className="rounded-card border border-solid border-[#e9e9ed] bg-white p-[18px] transition-all duration-200 hover:-translate-y-[3px] hover:shadow-lift">
		<div className="flex items-center justify-between">
			<IconTile icon={icon} accent={accent} size="lg" iconSize={20} />
			{pill ? <Pill tone={pillTone}>{pill}</Pill> : null}
		</div>
		<div className="mt-[14px] text-[34px] font-black leading-none tracking-[-.03em] text-[#0f1115]">{value}</div>
		<div className="mt-2 text-[12.5px] font-medium text-[#6c6c75]">{label}</div>
	</div>
);

const HealthCard = ({ icon, accent, metric, label }) => (
	<div className="rounded-panel border border-solid border-[#e9e9ed] bg-white px-[18px] py-4">
		<div className="flex items-center gap-[10px]">
			<IconTile icon={icon} accent={accent} size="md" iconSize={16} />
			<div>
				<div className="text-[22px] font-black leading-none tracking-[-.02em] text-[#0f1115]">{metric.percent}%</div>
				<div className="mt-[3px] text-xs font-semibold text-[#52525b]">{label}</div>
			</div>
		</div>
		<ProgressBar percent={metric.percent} className="mt-[13px]" color={{ green: '#16a34a', violet: '#8b5cf6', amber: '#f59e0b', blue: '#2f5bea' }[accent]} />
		<div className="mt-[7px] text-[11px] text-[#6d6d74]">
			{sprintf(
				/* translators: 1: enabled widgets, 2: all widgets. */
				__('%1$d of %2$d enabled', 'ultimate-store-kit'),
				metric.active,
				metric.total
			)}
		</div>
	</div>
);

const ActionTile = ({ icon, accent, title, sub, onClick, href, external }) => {
	const className =
		'group flex cursor-pointer flex-col gap-[10px] rounded-panel border border-solid border-[#ececf0] bg-white p-4 text-left no-underline transition-all duration-200 hover:-translate-y-[2px] hover:border-[#fbc8cd] hover:shadow-lift';
	const inner = (
		<>
			<IconTile icon={icon} accent={accent} size="md" iconSize={16} />
			<span>
				<span className="block text-[14px] font-bold text-[#0f1115]">{title}</span>
				<span className="mt-0.5 block text-[12px] text-[#8a8a93]">{sub}</span>
			</span>
		</>
	);
	return href ? (
		<a href={href} className={className} target={external ? '_blank' : undefined} rel={external ? 'noopener noreferrer' : undefined}>
			{inner}
		</a>
	) : (
		<button type="button" onClick={onClick} className={className}>
			{inner}
		</button>
	);
};

const STATUS_DOT = {
	ok: 'bg-[#22c55e]',
	warn: 'bg-[#f59e0b]',
	bad: 'bg-[#ef4444]',
};

const STATUS_TEXT = {
	ok: 'text-[#15803d]',
	warn: 'text-[#b45309]',
	bad: 'text-[#b91c1c]',
};

const ReleaseRow = ({ release, current, color }) => (
	<li className="relative m-0 border-0 pb-4 pl-5 last:pb-0">
		<span className="absolute left-0 top-[6px] h-2 w-2 rounded-full" style={{ background: color }} />
		<div className="flex items-center justify-between gap-3">
			<span className="flex items-center gap-2 text-[14px] font-bold text-[#0f1115]">
				v{release.version}
				{current ? (
					<span className="rounded-full bg-gradient-brand px-2 py-[3px] text-[10px] font-extrabold uppercase tracking-[.06em] text-white">
						{__('Current', 'ultimate-store-kit')}
					</span>
				) : null}
			</span>
			{release.date ? <span className="text-[12px] text-[#8a8a93]">{release.date}</span> : null}
		</div>
		{release.summary ? <p className="m-0 mt-1 line-clamp-2 text-[12.5px] leading-relaxed text-[#52525b]">{release.summary}</p> : null}
		<div className="mt-2 flex flex-wrap gap-1.5">
			{release.counts?.added ? <Pill tone="green">{sprintf(/* translators: %d: count. */ __('%d added', 'ultimate-store-kit'), release.counts.added)}</Pill> : null}
			{release.counts?.fixed ? <Pill tone="blue">{sprintf(/* translators: %d: count. */ __('%d fixed', 'ultimate-store-kit'), release.counts.fixed)}</Pill> : null}
			{release.counts?.updated ? <Pill tone="amber">{sprintf(/* translators: %d: count. */ __('%d updated', 'ultimate-store-kit'), release.counts.updated)}</Pill> : null}
		</div>
	</li>
);

const RELEASE_COLORS = ['#22c55e', '#2f5bea', '#8b5cf6', '#f59e0b', '#14b8a6'];

const Welcome = ({ widgets, settings, isPro = false, moduleItems = [], onNavigate }) => {
	const stats = useMemo(() => {
		const wc = countWidgets(widgets[SECTIONS.wc], settings[SECTIONS.wc], isPro);
		const edd = countWidgets(widgets[SECTIONS.edd], settings[SECTIONS.edd], isPro);
		const other = countWidgets(widgets[SECTIONS.other], settings[SECTIONS.other], isPro);
		const modulesActive = moduleItems.filter((item) => getModuleInfo(item, settings).status === 'on').length;
		return {
			wc,
			edd,
			other,
			total: wc.total + edd.total + other.total,
			active: wc.active + edd.active + other.active,
			modulesActive,
		};
	}, [widgets, settings, isPro, moduleItems]);

	const optimizationOn = ((settings.ultimate_store_kit_other_settings || {})['asset-manager'] || 'off') === 'on';
	const suggestions = [];

	if (!optimizationOn) {
		suggestions.push({
			key: 'performance',
			icon: GaugeIcon,
			accent: 'green',
			title: __('Optimize asset loading', 'ultimate-store-kit'),
			text: __('Turn on Asset Optimization so pages only load the CSS/JS they use.', 'ultimate-store-kit'),
			link: __('Open performance', 'ultimate-store-kit'),
			page: 'performance',
		});
	}

	if (!Number(adminData.templatesActive)) {
		suggestions.push({
			key: 'templates',
			icon: TemplateIcon,
			accent: 'amber',
			title: __('Design your shop pages', 'ultimate-store-kit'),
			text: __('Build shop, product, cart and checkout templates with Elementor.', 'ultimate-store-kit'),
			link: __('Open Template Builder', 'ultimate-store-kit'),
			href: adminData.templateBuilderUrl,
		});
	}

	if (moduleItems.length && !stats.modulesActive) {
		suggestions.push({
			key: 'modules',
			icon: ModulesIcon,
			accent: 'violet',
			title: __('Switch on a store module', 'ultimate-store-kit'),
			text: __('Size charts, badges, free shipping bar, quick checkout and more.', 'ultimate-store-kit'),
			link: __('Browse modules', 'ultimate-store-kit'),
			page: 'modules',
		});
	}

	const WelcomeExtra = applyFilters('usk.admin.welcomeExtra', null);
	const hasLicensePage = !!applyFilters('usk.admin.pages', {}).license;
	const releases = adminData.releases || [];
	const system = adminData.system || [];
	const go = (page) => onNavigate && onNavigate(page);

	return (
		<div>
			<div className="mb-[22px]">
				<h1 className="m-0 text-[28px] font-extrabold tracking-[-.02em] text-[#0f1115]">
					{adminData.userName
						? sprintf(
								/* translators: %s: user display name. */
								__('Welcome back, %s', 'ultimate-store-kit'),
								adminData.userName
						  )
						: __('Welcome back', 'ultimate-store-kit')}
				</h1>
				<p className="m-0 mt-1.5 text-[13.5px] text-[#6c6c75]">
					{__("Here's what's happening across your store.", 'ultimate-store-kit')}
				</p>
			</div>

			<div className="grid grid-cols-4 gap-[14px] max-[1024px]:grid-cols-2 max-[560px]:grid-cols-1">
				<StatCard icon={WidgetsIcon} accent="blue" value={stats.total} label={__('Total widgets', 'ultimate-store-kit')} />
				<StatCard icon={ZapIcon} accent="green" value={stats.active} label={__('Widgets enabled', 'ultimate-store-kit')} pill={__('live', 'ultimate-store-kit')} pillTone="blue" />
				<StatCard
					icon={ModulesIcon}
					accent="violet"
					value={stats.modulesActive}
					label={__('Modules active', 'ultimate-store-kit')}
					pill={sprintf(/* translators: %d: number of modules. */ __('of %d', 'ultimate-store-kit'), moduleItems.length)}
				/>
				<StatCard
					icon={TemplateIcon}
					accent="amber"
					value={adminData.templatesCount || 0}
					label={__('Builder templates', 'ultimate-store-kit')}
					pill={Number(adminData.templatesActive) > 0 ? sprintf(/* translators: %d: active templates. */ __('%d active', 'ultimate-store-kit'), Number(adminData.templatesActive)) : null}
					pillTone="green"
				/>
			</div>

			<div className="mt-[14px] grid grid-cols-3 gap-[14px] max-[1024px]:grid-cols-2 max-[640px]:grid-cols-1">
				<HealthCard icon={CartIcon} accent="green" metric={stats.wc} label={__('WooCommerce widgets', 'ultimate-store-kit')} />
				<HealthCard icon={DownloadIcon} accent="violet" metric={stats.edd} label={__('EDD widgets', 'ultimate-store-kit')} />
				<HealthCard icon={LayersIcon} accent="amber" metric={stats.other} label={__('Other widgets', 'ultimate-store-kit')} />
			</div>

			<div className="mt-[14px] grid grid-cols-[minmax(0,1fr)_400px] items-start gap-[14px] max-[1180px]:grid-cols-1">
				<div className="flex min-w-0 flex-col gap-[14px]">
					<Card title={__('Quick actions', 'ultimate-store-kit')}>
						<div className="grid grid-cols-3 gap-[10px] max-[720px]:grid-cols-2 max-[440px]:grid-cols-1">
							<ActionTile
								icon={WidgetsIcon}
								accent="blue"
								title={__('Widgets', 'ultimate-store-kit')}
								sub={sprintf(/* translators: %d: number of widgets. */ __('Toggle %d elements', 'ultimate-store-kit'), stats.total)}
								onClick={() => go('woocommerce-widgets')}
							/>
							<ActionTile
								icon={ModulesIcon}
								accent="violet"
								title={__('Modules', 'ultimate-store-kit')}
								sub={sprintf(/* translators: %d: number of modules. */ __('%d store features', 'ultimate-store-kit'), moduleItems.length)}
								onClick={() => go('modules')}
							/>
							<ActionTile
								icon={TemplateIcon}
								accent="amber"
								title={__('Template Builder', 'ultimate-store-kit')}
								sub={__('Shop, product & cart pages', 'ultimate-store-kit')}
								href={adminData.templateBuilderUrl}
							/>
							{hasLicensePage ? (
								<ActionTile icon={KeyIcon} accent="green" title={__('License', 'ultimate-store-kit')} sub={isPro ? __('Pro is active', 'ultimate-store-kit') : __('Activate Pro', 'ultimate-store-kit')} onClick={() => go('license')} />
							) : (
								<ActionTile icon={ZapIcon} accent="rose" title={__('Get Pro', 'ultimate-store-kit')} sub={__('Unlock every module', 'ultimate-store-kit')} onClick={() => go('get-pro')} />
							)}
							<ActionTile icon={BookIcon} accent="teal" title={__('Documentation', 'ultimate-store-kit')} sub={__('Guides & tutorials', 'ultimate-store-kit')} href="https://bdthemes.com/knowledge-base/ultimate-store-kit/" external />
							<ActionTile icon={HeadsetIcon} accent="slate" title={__('Support', 'ultimate-store-kit')} sub={__('Get help from the team', 'ultimate-store-kit')} href="https://bdthemes.com/support/" external />
						</div>
					</Card>

					{WelcomeExtra ? <WelcomeExtra /> : null}

					{releases.length ? (
						<Card
							title={__('Recent activity', 'ultimate-store-kit')}
							action={
								<a href="https://wordpress.org/plugins/ultimate-store-kit/#developers" target="_blank" rel="noopener noreferrer" className="text-[13px] font-bold text-[#e30c1d] no-underline hover:underline">
									{__('View all', 'ultimate-store-kit')}
								</a>
							}
						>
							<ul className="m-0 list-none p-0">
								{releases.map((release, index) => (
									<ReleaseRow key={release.version} release={release} current={release.version === adminData.version} color={RELEASE_COLORS[index % RELEASE_COLORS.length]} />
								))}
							</ul>
						</Card>
					) : null}
				</div>

				<div className="flex min-w-0 flex-col gap-[14px]">
					{suggestions.length ? (
						<Card
							title={__('Suggestions', 'ultimate-store-kit')}
							action={<Pill tone="blue">{sprintf(/* translators: %d: number of suggestions. */ __('%d new', 'ultimate-store-kit'), suggestions.length)}</Pill>}
						>
							<div className="flex flex-col gap-2">
								{suggestions.map((item) => {
									const inner = (
										<>
											<IconTile icon={item.icon} accent={item.accent} size="md" iconSize={16} />
											<span className="min-w-0 flex-1">
												<span className="block text-[13.5px] font-bold text-[#0f1115]">{item.title}</span>
												<span className="mt-0.5 block text-[12px] leading-relaxed text-[#6c6c75]">{item.text}</span>
												<span className="mt-1.5 inline-flex items-center gap-1 text-[12.5px] font-bold text-[#e30c1d]">
													{item.link}
													<ArrowRightIcon size={13} />
												</span>
											</span>
										</>
									);
									const rowClass =
										'box-border flex w-full cursor-pointer gap-3 rounded-panel border border-solid border-[#ececf0] bg-white p-3 text-left no-underline transition-colors hover:border-[#fbc8cd]';
									return item.href ? (
										<a key={item.key} href={item.href} className={rowClass}>
											{inner}
										</a>
									) : (
										<button key={item.key} type="button" onClick={() => go(item.page)} className={rowClass}>
											{inner}
										</button>
									);
								})}
							</div>
						</Card>
					) : null}

					{isPro ? (
						<div className="relative overflow-hidden rounded-card bg-[linear-gradient(135deg,#3a0a10,#8f0b16_55%,#e30c1d)] p-[22px] text-white">
							<span className="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10" aria-hidden="true" />
							<span className="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-2.5 py-1 text-[11px] font-bold uppercase tracking-[.06em]">
								<SparkIcon size={12} />
								{__("What's new", 'ultimate-store-kit')}
							</span>
							<h3 className="m-0 mt-3 text-[20px] font-extrabold text-white">
								{sprintf(/* translators: %s: version. */ __('Ultimate Store Kit %s', 'ultimate-store-kit'), adminData.version)}
							</h3>
							<p className="m-0 mt-1.5 line-clamp-3 text-[13px] leading-relaxed text-white/80">
								{releases[0]?.summary || __('See everything added, fixed and improved in this update.', 'ultimate-store-kit')}
							</p>
							<button type="button" onClick={() => go('modules')} className="mt-4 inline-flex cursor-pointer items-center gap-1.5 rounded-full border-0 bg-white px-4 py-2 text-[13px] font-bold text-[#e30c1d]">
								{__('Explore modules', 'ultimate-store-kit')}
								<ChevronRightIcon size={14} />
							</button>
						</div>
					) : (
						<div className="relative overflow-hidden rounded-card bg-[linear-gradient(135deg,#3a0a10,#8f0b16_55%,#e30c1d)] p-[22px] text-white">
							<span className="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10" aria-hidden="true" />
							<span className="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-2.5 py-1 text-[11px] font-bold uppercase tracking-[.06em]">
								<ZapIcon size={12} />
								{__('Go Pro', 'ultimate-store-kit')}
							</span>
							<h3 className="m-0 mt-3 text-[20px] font-extrabold text-white">{__('Sell more with Pro modules', 'ultimate-store-kit')}</h3>
							<p className="m-0 mt-1.5 text-[13px] leading-relaxed text-white/80">
								{__('Partial payments, cart recovery, size charts, badges, upsells, currency switcher and every Pro widget.', 'ultimate-store-kit')}
							</p>
							<a href="https://storekit.pro/pricing/" target="_blank" rel="noopener noreferrer" className="mt-4 inline-flex items-center gap-1.5 rounded-full bg-white px-4 py-2 text-[13px] font-bold text-[#e30c1d] no-underline">
								{__('Get Pro', 'ultimate-store-kit')}
								<ChevronRightIcon size={14} />
							</a>
						</div>
					)}

					{system.length ? (
						<Card
							title={__('System status', 'ultimate-store-kit')}
							action={
								<button type="button" onClick={() => go('about')} className="cursor-pointer border-0 bg-transparent p-0 text-[13px] font-bold text-[#e30c1d] hover:underline">
									{__('Details', 'ultimate-store-kit')}
								</button>
							}
						>
							<ul className="m-0 list-none p-0">
								{system.map((row) => (
									<li key={row.label} className="m-0 flex items-center justify-between gap-3 border-0 border-b border-solid border-[#f0f0f3] py-[9px] text-[13px] last:border-b-0">
										<span className="text-[#3f3f46]">{row.label}</span>
										<span className={`flex items-center gap-1.5 font-bold ${STATUS_TEXT[row.status] || STATUS_TEXT.ok}`}>
											<span className={`h-[7px] w-[7px] rounded-full ${STATUS_DOT[row.status] || STATUS_DOT.ok}`} />
											{row.value}
										</span>
									</li>
								))}
							</ul>
						</Card>
					) : null}

					<Card title={__('Resources & help', 'ultimate-store-kit')}>
						<div className="flex flex-col gap-2">
							{[
								{ icon: BookIcon, accent: 'blue', title: __('Documentation', 'ultimate-store-kit'), sub: __('Guides & tutorials', 'ultimate-store-kit'), href: 'https://bdthemes.com/knowledge-base/ultimate-store-kit/' },
								{ icon: ActivityIcon, accent: 'rose', title: __("What's new", 'ultimate-store-kit'), sub: __('Release notes', 'ultimate-store-kit'), href: 'https://wordpress.org/plugins/ultimate-store-kit/#developers' },
								{ icon: HeadsetIcon, accent: 'violet', title: __('Support', 'ultimate-store-kit'), sub: __('Get help from the team', 'ultimate-store-kit'), href: 'https://bdthemes.com/support/' },
								{ icon: MessageIcon, accent: 'green', title: __('Request a feature', 'ultimate-store-kit'), sub: __('Tell us what to build next', 'ultimate-store-kit'), href: 'https://feedback.bdthemes.com/b/6vr2250l/feature-requests/' },
							].map((link) => (
								<a
									key={link.title}
									href={link.href}
									target="_blank"
									rel="noopener noreferrer"
									className="flex items-center gap-3 rounded-panel border border-solid border-[#ececf0] px-3 py-[10px] no-underline transition-colors hover:border-[#fbc8cd]"
								>
									<IconTile icon={link.icon} accent={link.accent} size="md" iconSize={16} />
									<span className="flex-1">
										<span className="block text-[13.5px] font-bold text-[#0f1115]">{link.title}</span>
										<span className="block text-[12px] text-[#8a8a93]">{link.sub}</span>
									</span>
									<span className="text-[#a1a1aa]">
										<ExternalIcon size={14} />
									</span>
								</a>
							))}
						</div>
					</Card>
				</div>
			</div>
		</div>
	);
};

export default Welcome;
