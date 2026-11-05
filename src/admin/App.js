import { useState, useCallback, useEffect } from '@wordpress/element';
import { applyFilters, addAction, removeAction } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import AppBar from './components/shell/AppBar';
import TabStrip from './components/shell/TabStrip';
import Welcome from './pages/Welcome';
import ModulesPage from './pages/ModulesPage';
import PerformancePage from './pages/PerformancePage';
import OtherPluginsPage from './pages/OtherPluginsPage';
import WidgetsPage from './pages/WidgetsPage';
import OtherSettings from './pages/OtherSettings';
import GetPro from './pages/GetPro';
import AboutInfo from './pages/AboutInfo';
import ProModulePlaceholder from './pages/ProModulePlaceholder';
import Toast from './components/Toast';
import { getPlaceholderModules, getModuleSidebarIcon, proGroupDescriptions, buildSidebarSections } from './utils';
import { DashboardIcon, WidgetsIcon, ModulesIcon, TemplateIcon, KeyIcon, ZapIcon, InfoIcon, ArrowLeftIcon, GaugeIcon, PlugIcon } from './components/ui/Icons';
import { ProTag } from './components/ui/Primitives';

const adminData = window.ultimateStoreKitAdminData || {};

const slugify = (label) =>
	label.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');

const getSettingsGroups = () => {
	const widgets = adminData.widgets?.ultimate_store_kit_other_settings || [];
	const groups = [];
	widgets.forEach((w) => {
		if (w.type === 'start_group') {
			groups.push({ id: `settings-${slugify(w.label)}`, label: w.label, proOnly: false });
		} else if (w.parent && w.widget_type === 'pro' && groups.length) {
			// The group's main switch is a Pro feature, so the whole group is.
			groups[groups.length - 1].proOnly = true;
		}
	});
	return groups;
};

const settingsGroups = getSettingsGroups();

/**
 * The locked "Get Pro" page for a Pro-only settings group (Flash Sale
 * Countdown, Back Order, Pre-Order), so they match the other Pro modules.
 */
const getProGroupPlaceholder = (pageId) => {
	const group = settingsGroups.find((g) => g.id === pageId && g.proOnly);
	if (!group) {
		return null;
	}
	const icon = getModuleSidebarIcon(group);
	return { id: group.id, label: group.label, icon, description: proGroupDescriptions[icon] || '', badge: 'Pro', proPlaceholder: true };
};

const getPageFromHash = () => {
	const hash = window.location.hash.replace('#', '');
	const pageName = hash.split('?')[0];

	const placeholderIds = getPlaceholderModules().map((p) => p.id);
	const proPages = applyFilters('usk.admin.pages', {});
	const proPageIds = Object.keys(proPages);

	const corePages = [
		'welcome',
		'widgets',
		'woocommerce-widgets',
		'edd-widgets',
		'other-widgets',
		'modules',
		'performance',
		'other-plugins',
		'get-pro',
		'about',
		...settingsGroups.map((g) => g.id),
		...placeholderIds,
		...proPageIds,
	];

	const validPages = applyFilters('usk.admin.validPages', corePages);
	return validPages.includes(pageName) ? pageName : 'welcome';
};

const App = () => {
	const [activePage, setActivePage] = useState(getPageFromHash());
	// One settings object for the whole dashboard: Pro module pages switch modules
	// by writing into adminData.savedSettings directly (see Pro's moduleState.js),
	// so the state wraps that same object instead of a copy. An empty option
	// arrives from PHP as [], which is turned into an object to write into.
	const [settings, setSettings] = useState(() => {
		adminData.savedSettings = adminData.savedSettings || {};
		Object.keys(adminData.savedSettings).forEach((key) => {
			if (Array.isArray(adminData.savedSettings[key])) {
				adminData.savedSettings[key] = {};
			}
		});
		return { ...adminData.savedSettings };
	});
	const [isProActive, setIsProActive] = useState(!!adminData.isPro);
	const [saving, setSaving] = useState(false);
	const [notification, setNotification] = useState(null);

	// Allow pro (or any extension) to trigger toasts via doAction('usk.admin.notify', {...})
	useEffect(() => {
		const handleNotify = (data) => setNotification(data);
		addAction('usk.admin.notify', 'usk-core', handleNotify);
		return () => removeAction('usk.admin.notify', 'usk-core');
	}, []);

	// Listen for license activation/deactivation from Pro's LicensePage
	useEffect(() => {
		const handleLicenseChanged = (active) => {
			setIsProActive(active);
			window.ultimateStoreKitAdminData.isPro = active;
		};
		addAction('usk.admin.licenseChanged', 'usk-core', handleLicenseChanged);
		return () => removeAction('usk.admin.licenseChanged', 'usk-core');
	}, []);

	useEffect(() => {
		if (notification) {
			const timer = setTimeout(() => setNotification(null), 3000);
			return () => clearTimeout(timer);
		}
	}, [notification]);

	useEffect(() => {
		const handleHashChange = () => {
			setActivePage(getPageFromHash());
			// Pick up module switches made on the page just left.
			setSettings({ ...adminData.savedSettings });
		};

		window.addEventListener('hashchange', handleHashChange);
		return () => window.removeEventListener('hashchange', handleHashChange);
	}, []);

	useEffect(() => {
		// When pro plugin is installed, Get Pro is replaced by License.
		// Redirect stale get-pro links to license (if registered) or welcome.
		if (activePage === 'get-pro') {
			const proPages = applyFilters('usk.admin.pages', {});
			if (proPages.license || isProActive) {
				const target = proPages.license ? 'license' : 'welcome';
				setActivePage(target);
				window.location.hash = `#${target}`;
			}
		}
	}, [isProActive, activePage]);


	const saveSettings = useCallback(
		(section, sectionSettings) => {
			setSaving(true);

			fetch(adminData.restUrl + 'settings', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': adminData.restNonce,
				},
				body: JSON.stringify({ section, settings: sectionSettings }),
			})
				.then((res) => {
					if (!res.ok) throw res;
					return res.json();
				})
				.then((data) => {
					// Update the shared section object in place (other code holds it).
					if (!adminData.savedSettings[section] || Array.isArray(adminData.savedSettings[section])) {
						adminData.savedSettings[section] = {};
					}
					Object.assign(adminData.savedSettings[section], sectionSettings);
					setSettings({ ...adminData.savedSettings });
					setNotification({
						type: 'success',
						message:
							data?.message ||
							__('Settings saved successfully.', 'ultimate-store-kit'),
					});
				})
				.catch(() => {
					setNotification({
						type: 'error',
						message: __(
							'An error occurred while saving.',
							'ultimate-store-kit'
						),
					});
				})
				.finally(() => {
					setSaving(false);
				});
		},
		[]
	);

	const navigate = useCallback((pageId) => {
		setActivePage(pageId);
		if (window.location.hash !== `#${pageId}`) {
			window.location.hash = `#${pageId}`;
		}
		window.scrollTo({ top: 0, behavior: 'smooth' });
	}, []);

	// The Modules section of the old sidebar (core settings groups, Pro
	// modules and their placeholders) is now the Modules page.
	const sidebarSections = buildSidebarSections({ isPro: isProActive, settingsGroups });
	const moduleItems = (sidebarSections.find((section) => section.id === 'modules') || { items: [] }).items;
	const supportItems = (sidebarSections.find((section) => section.id === 'support') || { items: [] }).items;
	const moduleIds = moduleItems.map((item) => item.id);
	const proPagesForNav = applyFilters('usk.admin.pages', {});
	const hasLicensePage = !!proPagesForNav.license;
	const widgetPageIds = ['widgets', 'woocommerce-widgets', 'edd-widgets', 'other-widgets'];

	const tabs = [
		{ key: 'welcome', label: __('Dashboard', 'ultimate-store-kit'), icon: DashboardIcon, active: activePage === 'welcome' },
		{ key: 'woocommerce-widgets', label: __('Widgets', 'ultimate-store-kit'), icon: WidgetsIcon, active: widgetPageIds.includes(activePage) },
		{ key: 'modules', label: __('Modules', 'ultimate-store-kit'), icon: ModulesIcon, active: activePage === 'modules' || moduleIds.includes(activePage) },
		{ key: 'performance', label: __('Performance', 'ultimate-store-kit'), icon: GaugeIcon, active: activePage === 'performance' },
		{ key: 'template-builder', label: __('Template Builder', 'ultimate-store-kit'), icon: TemplateIcon, href: adminData.templateBuilderUrl },
	];

	if (hasLicensePage) {
		tabs.push({ key: 'license', label: __('License', 'ultimate-store-kit'), icon: KeyIcon, active: activePage === 'license' });
	} else if (!isProActive) {
		tabs.push({ key: 'get-pro', label: __('Get Pro', 'ultimate-store-kit'), icon: ZapIcon, active: activePage === 'get-pro' });
	}

	tabs.push({ key: 'about', label: __('About & Info', 'ultimate-store-kit'), icon: InfoIcon, active: activePage === 'about' });
	tabs.push({ key: 'other-plugins', label: __('Other Plugins', 'ultimate-store-kit'), icon: PlugIcon, active: activePage === 'other-plugins' });

	// Anything else an add-on puts in the old sidebar's Support group goes to "More".
	const shownTabKeys = tabs.map((tab) => tab.key);
	const moreItems = supportItems
		.filter((item) => !shownTabKeys.includes(item.id) && !(item.id === 'get-pro' && (isProActive || hasLicensePage)))
		.map((item) => ({
			key: item.id,
			label: item.label,
			icon: item.id === 'license' ? KeyIcon : item.id === 'get-pro' ? ZapIcon : InfoIcon,
			active: activePage === item.id,
		}));

	const searchItems = [
		{ id: 'welcome', label: __('Dashboard', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'woocommerce-widgets', label: __('WooCommerce widgets', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'edd-widgets', label: __('EDD widgets', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'other-widgets', label: __('Other widgets', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'modules', label: __('All modules', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'template-builder', label: __('Template Builder', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit'), href: adminData.templateBuilderUrl },
		{ id: 'performance', label: __('Performance', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'about', label: __('About & Info', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		{ id: 'other-plugins', label: __('Other Plugins', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') },
		...(hasLicensePage ? [{ id: 'license', label: __('License', 'ultimate-store-kit'), group: __('Pages', 'ultimate-store-kit') }] : []),
		...moreItems.map((item) => ({ id: item.key, label: item.label, group: __('Pages', 'ultimate-store-kit') })),
		...moduleItems.map((item) => ({ id: item.id, label: item.label, group: __('Modules', 'ultimate-store-kit') })),
		...[
			['ultimate_store_kit_active_modules', 'woocommerce-widgets'],
			['ultimate_store_kit_edd_modules', 'edd-widgets'],
			['ultimate_store_kit_general_modules', 'other-widgets'],
		].flatMap(([key, page]) =>
			(adminData.widgets?.[key] || [])
				.filter((w) => w.type === 'checkbox')
				.map((w) => ({ id: `${page}?search=${encodeURIComponent(w.label)}`, label: w.label, group: __('Widgets', 'ultimate-store-kit') }))
		),
	];

	const onSearchSelect = (item) => {
		if (item.href) {
			window.location.href = item.href;
			return;
		}
		window.location.hash = `#${item.id}`;
		window.scrollTo({ top: 0, behavior: 'smooth' });
	};

	const activeModule = moduleItems.find((item) => item.id === activePage);

	const renderPage = () => {
		const widgets = adminData.widgets || {};

		// Check pro-registered pages first
		const proPages = applyFilters('usk.admin.pages', {});
		if (proPages[activePage]) {
			// If user doesn't have an active license, show placeholder for module pages
			if (!isProActive) {
				const placeholders = getPlaceholderModules();
				const placeholder = placeholders.find((p) => p.id === activePage) || getProGroupPlaceholder(activePage);
				if (placeholder) {
					return <ProModulePlaceholder module={placeholder} />;
				}
			}
			const ProPageComponent = proPages[activePage];
			return <ProPageComponent />;
		}

		// Check placeholder modules (upsell for non-pro users)
		const placeholders = getPlaceholderModules();
		const placeholder = placeholders.find((p) => p.id === activePage) || (!isProActive && getProGroupPlaceholder(activePage));
		if (placeholder) {
			return <ProModulePlaceholder module={placeholder} />;
		}

		switch (activePage) {
			case 'welcome':
				return (
					<Welcome
						widgets={widgets}
						settings={settings}
						isPro={isProActive}
						moduleItems={moduleItems}
						onNavigate={navigate}
					/>
				);
			case 'other-plugins':
				return <OtherPluginsPage onNotify={setNotification} />;
			case 'performance':
				return <PerformancePage settings={settings} onSave={saveSettings} saving={saving} />;
			case 'modules':
				return (
					<ModulesPage
						items={moduleItems}
						settings={settings}
						isPro={isProActive}
						onNavigate={navigate}
					/>
				);
			case 'widgets':
			case 'woocommerce-widgets':
			case 'edd-widgets':
			case 'other-widgets': {
				const widgetTypeMap = {
					'woocommerce-widgets': 'wc',
					'edd-widgets': 'edd',
					'other-widgets': 'other',
					'widgets': 'wc'
				};
				return (
					<WidgetsPage
						allWidgets={widgets}
						allSettings={settings}
						onSave={saveSettings}
						saving={saving}
						isPro={isProActive}
						widgetType={widgetTypeMap[activePage]}
						onNavigate={navigate}
					/>
				);
			}
			case 'get-pro':
				return isProActive ? (
					<Welcome
						widgets={widgets}
						settings={settings}
						isPro={isProActive}
						moduleItems={moduleItems}
						onNavigate={navigate}
					/>
				) : (
					<GetPro isPro={isProActive} />
				);
			case 'about':
				return <AboutInfo />;
			default: {
				const settingsGroup = settingsGroups.find((g) => g.id === activePage);
				if (settingsGroup) {
					return (
						<OtherSettings
							widgets={widgets.ultimate_store_kit_other_settings || []}
							section="ultimate_store_kit_other_settings"
							settings={settings.ultimate_store_kit_other_settings || {}}
							onSave={saveSettings}
							saving={saving}
							isPro={isProActive}
							activeGroup={settingsGroup.label}
						/>
					);
				}
				return <Welcome widgets={widgets} settings={settings} isPro={isProActive} moduleItems={moduleItems} onNavigate={navigate} />;
			}
		}
	};

	return (
		<div className="usk-app min-h-[calc(100vh-32px)] bg-[#f0f0f1] text-sm text-[#1d2327]">
			<Toast notification={notification} onDismiss={() => setNotification(null)} />
			<div className="mx-auto box-border w-full max-w-[1400px] px-12 pb-[60px] pt-[30px] max-[1024px]:px-7 max-[1024px]:pt-6 max-[640px]:px-0 max-[640px]:pt-4">
				<div className="rounded-card border border-solid border-[#e6e6ea] bg-white">
					<AppBar
						version={adminData.version}
						isPro={isProActive}
						isProPluginActive={!!adminData.isProPluginActive}
						templateBuilderUrl={adminData.templateBuilderUrl}
						searchItems={searchItems}
						onSearchSelect={onSearchSelect}
					/>
					<TabStrip tabs={tabs} moreItems={moreItems} onNavigate={navigate} />
				</div>

				<main className="mt-[26px]">
					{activeModule ? (
						<div className="mb-4 flex flex-wrap items-center gap-2 text-[13px] font-semibold text-[#6c6c75]">
							<button
								type="button"
								onClick={() => navigate('modules')}
								className="inline-flex cursor-pointer items-center gap-1.5 rounded-full border border-solid border-[#e6e6ea] bg-white px-3 py-1.5 text-[13px] font-bold text-[#3f3f46] transition-colors hover:border-[#e30c1d] hover:text-[#e30c1d]"
							>
								<ArrowLeftIcon size={14} />
								{__('All modules', 'ultimate-store-kit')}
							</button>
							<span aria-hidden="true">/</span>
							<span className="text-[#0f1115]">{activeModule.label}</span>
							{activeModule.badge && !isProActive ? <ProTag /> : null}
						</div>
					) : null}
					{renderPage()}
				</main>

				<footer className="mt-10 text-center text-[12.5px] text-[#8a8a93]">
					{__('Ultimate Store Kit Addon made with love by', 'ultimate-store-kit')}{' '}
					<a target="_blank" rel="noopener noreferrer" href="https://bdthemes.com" className="font-semibold text-[#e30c1d] no-underline hover:underline">
						BdThemes
					</a>
					. {__('All rights reserved.', 'ultimate-store-kit')}
				</footer>
			</div>
		</div>
	);
};

export default App;
