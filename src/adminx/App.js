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

const adminData = window.ultimateStoreKitAdminData || {};

const getPageFromHash = () => {
	const hash = window.location.hash.replace('#', '');
	const pageName = hash.split('?')[0];
	const validPages = [
		'welcome',
		'widgets',
		'other-settings',
		'get-pro',
		'license',
		'about',
	];
	return validPages.includes(pageName) ? pageName : 'welcome';
};

const App = () => {
	const [activePage, setActivePage] = useState(getPageFromHash());
	const [settings, setSettings] = useState(adminData.savedSettings || {});
	const [isProActive, setIsProActive] = useState(!!adminData.isPro);
	const [saving, setSaving] = useState(false);
	const [notification, setNotification] = useState(null);

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

	const saveSettings = useCallback(
		(section, sectionSettings) => {
			setSaving(true);

			const formData = new FormData();
			formData.append('action', 'ultimate_store_kit_save_settings');
			formData.append('nonce', adminData.nonce);
			formData.append('section', section);

			Object.keys(sectionSettings).forEach((key) => {
				formData.append(`settings[${key}]`, sectionSettings[key]);
			});

			fetch(adminData.ajaxUrl, {
				method: 'POST',
				body: formData,
			})
				.then((res) => res.json())
				.then((response) => {
					if (response.success) {
						setSettings((prev) => ({
							...prev,
							[section]: sectionSettings,
						}));
						setNotification({
							type: 'success',
							message: __(
								'Settings saved successfully.',
								'ultimate-store-kit'
							),
						});
					} else {
						setNotification({
							type: 'error',
							message: __(
								'Failed to save settings.',
								'ultimate-store-kit'
							),
						});
					}
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
		[adminData.ajaxUrl, adminData.nonce]
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
				return (
					<WidgetsPage
						allWidgets={widgets}
						allSettings={settings}
						onSave={saveSettings}
						saving={saving}
						isPro={isProActive}
					/>
				);
			case 'other-settings':
				return (
					<OtherSettings
						widgets={
							widgets.ultimate_store_kit_other_settings || []
						}
						section="ultimate_store_kit_other_settings"
						settings={
							settings.ultimate_store_kit_other_settings || {}
						}
						onSave={saveSettings}
						saving={saving}
						isPro={isProActive}
					/>
				);
			case 'get-pro':
				return <GetPro isPro={isProActive} />;
			case 'license':
				return (
					<License
						isPro={isProActive}
						onLicenseStatusChange={setIsProActive}
					/>
				);
			case 'about':
				return <AboutInfo />;
			default:
				return <Welcome widgets={widgets} settings={settings} />;
		}
	};

	return (
		<div className="usk-admin-app">
			<Header version={adminData.version} />
			<div className="usk-admin-body">
				<Sidebar
					activePage={activePage}
					onNavigate={setActivePage}
					isPro={isProActive}
				/>
				<div className="usk-admin-content">
					{notification && (
						<div
							className={`usk-notification usk-notification--${notification.type}`}
						>
							<span>{notification.message}</span>
							<button
								onClick={() => setNotification(null)}
								className="usk-notification__close"
							>
								×
							</button>
						</div>
					)}
					{renderPage()}
				</div>
			</div>
		</div>
	);
};

export default App;
