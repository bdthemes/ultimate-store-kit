import { useState, useCallback, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Welcome from './pages/Welcome';
import WidgetsPage from './pages/WidgetsPage';
import OtherSettings from './pages/OtherSettings';
import GetPro from './pages/GetPro';
import License from './pages/License';
import AboutInfo from './pages/AboutInfo';
import { appShell, bodyRow, mainContent } from './tw';
import Toast from './components/Toast';

const adminData = window.ultimateStoreKitAdminData || {};

const slugify = (label) =>
	label.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');

const getSettingsGroups = () => {
	const widgets = adminData.widgets?.ultimate_store_kit_other_settings || [];
	const groups = [];
	widgets.forEach((w) => {
		if (w.type === 'start_group') {
			groups.push({ id: `settings-${slugify(w.label)}`, label: w.label });
		}
	});
	return groups;
};

const settingsGroups = getSettingsGroups();

const getPageFromHash = () => {
	const hash = window.location.hash.replace('#', '');
	const pageName = hash.split('?')[0];
	const validPages = [
		'welcome',
		'widgets',
		'woocommerce-widgets',
		'edd-widgets',
		'other-widgets',
		'get-pro',
		'license',
		'about',
		...settingsGroups.map((g) => g.id),
	];
	return validPages.includes(pageName) ? pageName : 'welcome';
};

const App = () => {
	const [activePage, setActivePage] = useState(getPageFromHash());
	const [settings, setSettings] = useState(adminData.savedSettings || {});
	const [isProActive, setIsProActive] = useState(!!adminData.isPro);
	const [saving, setSaving] = useState(false);
	const [notification, setNotification] = useState(null);
	const [isSidebarOpen, setIsSidebarOpen] = useState(false);
	const [isDesktop, setIsDesktop] = useState(() => window.innerWidth > 1024);

	useEffect(() => {
		if (notification) {
			const timer = setTimeout(() => setNotification(null), 3000);
			return () => clearTimeout(timer);
		}
	}, [notification]);

	useEffect(() => {
		const handleHashChange = () => {
			setActivePage(getPageFromHash());
		};

		window.addEventListener('hashchange', handleHashChange);
		return () => window.removeEventListener('hashchange', handleHashChange);
	}, []);

	useEffect(() => {
		// Pro users don't need Get Pro page; redirect if opened directly.
		if (isProActive && activePage === 'get-pro') {
			setActivePage('welcome');
			window.location.hash = '#welcome';
		}
	}, [isProActive, activePage]);

	useEffect(() => {
		setIsSidebarOpen(false);
	}, [activePage]);

	useEffect(() => {
		document.body.style.overflow = isSidebarOpen ? 'hidden' : '';
		return () => {
			document.body.style.overflow = '';
		};
	}, [isSidebarOpen]);

	useEffect(() => {
		const handleResize = () => {
			const desktop = window.innerWidth > 1024;
			setIsDesktop(desktop);
			if (desktop) {
				setIsSidebarOpen(false);
			}
		};
		window.addEventListener('resize', handleResize);
		return () => window.removeEventListener('resize', handleResize);
	}, []);

	const handleToggleSidebar = useCallback((event) => {
		if (event?.preventDefault) event.preventDefault();
		if (event?.stopPropagation) event.stopPropagation();
		setIsSidebarOpen((prev) => !prev);
	}, []);

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
					setSettings((prev) => ({
						...prev,
						[section]: sectionSettings,
					}));
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

	const renderPage = () => {
		const widgets = adminData.widgets || {};

		switch (activePage) {
			case 'welcome':
				return (
					<Welcome
						widgets={widgets}
						settings={settings}
						isPro={isProActive}
					/>
				);
			case 'widgets':
			case 'woocommerce-widgets':
			case 'edd-widgets':
			case 'other-widgets':
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
					/>
				);
			case 'get-pro':
				return isProActive ? (
					<Welcome
						widgets={widgets}
						settings={settings}
						isPro={isProActive}
					/>
				) : (
					<GetPro isPro={isProActive} />
				);
			case 'license':
				return (
					<License
						isPro={isProActive}
						onLicenseStatusChange={setIsProActive}
					/>
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
				return <Welcome widgets={widgets} settings={settings} />;
			}
		}
	};

	return (
		<div className={appShell}>
			<Toast notification={notification} onDismiss={() => setNotification(null)} />
			<Header
				version={adminData.version}
				isPro={isProActive}
				isSidebarOpen={isSidebarOpen}
				isDesktop={isDesktop}
				onToggleSidebar={handleToggleSidebar}
			/>
			<div className="bg-slate-50">
			<div className={`${bodyRow} flex-col lg:flex-row`}>
				<Sidebar
					activePage={activePage}
					onNavigate={setActivePage}
					isPro={isProActive}
					isOpen={isSidebarOpen}
					isDesktop={isDesktop}
					onClose={() => setIsSidebarOpen(false)}
					settingsGroups={settingsGroups}
				/>
				<div className={`${mainContent} flex flex-col`}>
					<div className="flex-1">{renderPage()}</div>
				</div>
			</div>
			</div>
			<footer className="p-5 bg-white py-4 text-center text-sm text-slate-500 rounded-bl-lg rounded-br-lg">
				{__(
					'Ultimate Store Kit Addon made with love by',
					'ultimate-store-kit'
				)}{' '}
				<a
					target="_blank"
					rel="noopener noreferrer"
					href="https://bdthemes.com"
					className="text-uks-brand no-underline hover:underline"
				>
					BdThemes
				</a>
				. {__('All rights reserved.', 'ultimate-store-kit')}
			</footer>
		</div>
	);
};

export default App;
