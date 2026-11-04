/**
 * Other Plugins, laid out like Element Pack's: one card per BdThemes plugin
 * with its icon, version, description, status and Install / Activate /
 * Details actions.
 *
 * Data and installs go through the capability-checked REST routes in
 * includes/API/OtherPlugins.php (only listed slugs install); activation uses
 * WordPress core's nonce-signed link. Remote text is rendered as text and
 * remote URLs are used only when they are http(s).
 */
import { useState, useEffect, useCallback } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import { PlugIcon, ExternalIcon } from '../components/ui/Icons';
import { Pill } from '../components/ui/Primitives';

const adminData = window.ultimateStoreKitAdminData || {};

const safeUrl = (url) => {
	try {
		const parsed = new window.URL(String(url || ''), window.location.href);
		return parsed.protocol === 'https:' || parsed.protocol === 'http:' ? parsed.href : '';
	} catch (e) {
		return '';
	}
};

// "Ultimate Post Kit – Elementor Post Grid, …" → "Ultimate Post Kit", as Element Pack lists them.
const shortName = (name) => String(name || '').split(/\s[–—-]\s|:\s/)[0].trim() || String(name || '');

const formatInstalls = (count) => {
	if (!count) {
		return '';
	}
	if (count >= 1000000) {
		return sprintf(/* translators: %s: number of millions. */ __('%s M+ installs', 'ultimate-store-kit'), Math.floor(count / 1000000));
	}
	if (count >= 1000) {
		return sprintf(/* translators: %s: number of thousands. */ __('%s K+ installs', 'ultimate-store-kit'), Math.floor(count / 1000));
	}
	return sprintf(/* translators: %d: number of installs. */ __('%d+ installs', 'ultimate-store-kit'), count);
};

const request = async (path, options = {}) => {
	const response = await window.fetch((adminData.restUrl || '') + path, {
		credentials: 'same-origin',
		...options,
		headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': adminData.restNonce || '', ...(options.headers || {}) },
	});
	let json = null;
	try {
		json = await response.json();
	} catch (e) {
		json = null;
	}
	if (!response.ok) {
		throw new Error((json && json.message) || __('Something went wrong. Reload the page and try again.', 'ultimate-store-kit'));
	}
	return json || {};
};

const PluginIcon = ({ icon }) => {
	const [failed, setFailed] = useState(false);
	const src = safeUrl(icon);

	if (src && !failed) {
		return <img src={src} alt="" width="48" height="48" onError={() => setFailed(true)} className="h-12 w-12 flex-none rounded-tile object-cover" />;
	}

	return (
		<span className="grid h-12 w-12 flex-none place-items-center rounded-tile bg-[#fff1f2] text-[#e30c1d]" aria-hidden="true">
			<PlugIcon size={22} />
		</span>
	);
};

const STATUS = {
	active: { tone: 'green', label: __('Active', 'ultimate-store-kit') },
	installed: { tone: 'blue', label: __('Installed', 'ultimate-store-kit') },
	not_installed: { tone: 'neutral', label: __('Not installed', 'ultimate-store-kit') },
};

const OtherPluginsPage = ({ onNotify }) => {
	const [plugins, setPlugins] = useState(null);
	const [canInstall, setCanInstall] = useState(false);
	const [error, setError] = useState('');
	const [busy, setBusy] = useState({ slug: '', action: '' });

	const notify = (message, type = 'success') => onNotify && onNotify({ type, message });

	const load = useCallback(async () => {
		setError('');
		try {
			const data = await request('other-plugins');
			setPlugins(data.plugins || []);
			setCanInstall(!!data.canInstall);
		} catch (e) {
			setError(e.message);
			setPlugins((current) => current || []);
		}
	}, []);

	useEffect(() => {
		load();
	}, [load]);

	const install = async (plugin) => {
		setBusy({ slug: plugin.slug, action: 'install' });
		try {
			const data = await request('other-plugins/install', { method: 'POST', body: JSON.stringify({ slug: plugin.slug }) });
			notify(data.message || __('Plugin installed.', 'ultimate-store-kit'));
			await load();
		} catch (e) {
			notify(e.message, 'error');
		} finally {
			setBusy({ slug: '', action: '' });
		}
	};

	const activate = async (plugin) => {
		const url = safeUrl(plugin.activateUrl);
		if (!url) {
			return;
		}
		setBusy({ slug: plugin.slug, action: 'activate' });
		try {
			const response = await window.fetch(url, { credentials: 'same-origin' });
			if (!response.ok) {
				throw new Error(__('The plugin could not be activated.', 'ultimate-store-kit'));
			}
			notify(__('Plugin activated.', 'ultimate-store-kit'));
			await load();
		} catch (e) {
			notify(e.message, 'error');
		} finally {
			setBusy({ slug: '', action: '' });
		}
	};

	const btn =
		'inline-flex cursor-pointer items-center gap-1.5 rounded-full px-3.5 py-1.5 text-[12.5px] font-bold transition-all disabled:cursor-wait disabled:opacity-60';

	return (
		<div>
			<div className="mb-[18px]">
				<h1 className="m-0 text-[28px] font-extrabold tracking-[-.02em] text-[#0f1115]">{__('Other Plugins', 'ultimate-store-kit')}</h1>
				<p className="m-0 mt-1.5 text-[13.5px] text-[#6c6c75]">
					{__('Install companion plugins from BdThemes to extend your store.', 'ultimate-store-kit')}
				</p>
			</div>

			{error ? (
				<div className="mb-[14px] flex items-center justify-between gap-3 rounded-panel border border-solid border-[#fecaca] bg-[#fef2f2] px-4 py-3 text-[13px] font-semibold text-[#991b1b]" role="alert">
					<span>{error}</span>
					<button type="button" onClick={load} className="cursor-pointer rounded-full border border-solid border-[#fecaca] bg-white px-3 py-1 text-[12.5px] font-bold text-[#991b1b]">
						{__('Retry', 'ultimate-store-kit')}
					</button>
				</div>
			) : null}

			{plugins === null ? (
				<div className="grid grid-cols-3 gap-[14px] max-[1180px]:grid-cols-2 max-[700px]:grid-cols-1" aria-busy="true" aria-label={__('Loading plugins…', 'ultimate-store-kit')}>
					{Array.from({ length: 6 }).map((_, i) => (
						<div key={i} className="h-[190px] animate-pulse rounded-card border border-solid border-[#e9e9ed] bg-white" />
					))}
				</div>
			) : (
				<div className="grid grid-cols-3 gap-[14px] max-[1180px]:grid-cols-2 max-[700px]:grid-cols-1">
					{plugins.map((plugin) => {
						const status = STATUS[plugin.status] || STATUS.not_installed;
						const details = safeUrl(plugin.url);
						const isBusy = busy.slug === plugin.slug;
						return (
							<section
								key={plugin.slug}
								className="group flex flex-col gap-3 rounded-card border border-solid border-[#e9e9ed] bg-white p-5 transition-all duration-200 hover:-translate-y-[2px] hover:border-[#fbc8cd] hover:shadow-lift"
							>
								<div className="flex items-center gap-3">
									<PluginIcon icon={plugin.icon} />
									<div className="min-w-0">
										<h2 className="m-0 truncate text-[15px] font-extrabold tracking-[-.01em] text-[#0f1115]">{shortName(plugin.name)}</h2>
										<span className="text-[12px] font-semibold text-[#8a8a93]">
											{[plugin.version ? `v${plugin.version}` : '', formatInstalls(plugin.activeInstalls)].filter(Boolean).join(' · ')}
										</span>
									</div>
								</div>

								{plugin.description ? (
									<p className="m-0 line-clamp-3 flex-1 text-[13px] leading-relaxed text-[#6c6c75]">{plugin.description}</p>
								) : (
									<span className="flex-1" />
								)}

								<div className="mt-auto flex flex-wrap items-center gap-2 border-0 border-t border-solid border-[#f3f3f6] pt-3">
									<Pill tone={status.tone}>{status.label}</Pill>
									<span className="ml-auto flex items-center gap-2">
										{plugin.status === 'not_installed' && canInstall ? (
											<button type="button" disabled={!!busy.slug} onClick={() => install(plugin)} className={`${btn} border-0 bg-gradient-brand text-white shadow-glow`}>
												{isBusy && busy.action === 'install' ? __('Installing…', 'ultimate-store-kit') : __('Install', 'ultimate-store-kit')}
											</button>
										) : null}
										{plugin.status === 'installed' && plugin.activateUrl ? (
											<button type="button" disabled={!!busy.slug} onClick={() => activate(plugin)} className={`${btn} border border-solid border-[#e2e2e6] bg-white text-[#27272a] hover:border-[#e30c1d] hover:text-[#e30c1d]`}>
												{isBusy && busy.action === 'activate' ? __('Activating…', 'ultimate-store-kit') : __('Activate', 'ultimate-store-kit')}
											</button>
										) : null}
										{details ? (
											<a href={details} target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-1 text-[13px] font-bold text-[#e30c1d] no-underline hover:underline">
												{__('Details', 'ultimate-store-kit')}
												<ExternalIcon size={13} />
											</a>
										) : null}
									</span>
								</div>
							</section>
						);
					})}
				</div>
			)}
		</div>
	);
};

export default OtherPluginsPage;
