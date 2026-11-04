/**
 * Asset Optimization, laid out like Element Pack's Performance page: the
 * Asset Manager switch, then a status strip (state, combined files,
 * auto-regenerate) and what the switch changes.
 */
import { useState } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import { Toggle } from '../tw';
import { GaugeIcon, CheckIcon, LayersIcon, ZapIcon } from '../components/ui/Icons';
import { Card, IconTile } from '../components/ui/Primitives';

const adminData = window.ultimateStoreKitAdminData || {};
const SECTION = 'ultimate_store_kit_other_settings';
const FIELD = 'asset-manager';

const formatBytes = (bytes) => {
	if (!bytes) {
		return '0 KB';
	}
	return bytes >= 1048576 ? `${(bytes / 1048576).toFixed(1)} MB` : `${Math.max(1, Math.round(bytes / 1024))} KB`;
};

const PerformancePage = ({ settings, onSave, saving }) => {
	const saved = ((settings && settings[SECTION]) || {})[FIELD] === 'on';
	const [stats, setStats] = useState(adminData.assetStats || null);
	const [regenerating, setRegenerating] = useState(false);
	const [notice, setNotice] = useState('');

	const toggle = () => {
		const current = (settings && settings[SECTION]) || {};
		onSave(SECTION, { ...(Array.isArray(current) ? {} : current), [FIELD]: saved ? 'off' : 'on' });
	};

	const regenerate = () => {
		setRegenerating(true);
		setNotice('');
		fetch((adminData.restUrl || '') + 'optimization/regenerate', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': adminData.restNonce || '' },
		})
			.then((res) => {
				if (!res.ok) throw res;
				return res.json();
			})
			.then((data) => {
				const payload = data?.data || data || {};
				if (payload.stats) {
					setStats(payload.stats);
				}
				setNotice(payload.message || __('Combined files cleared.', 'ultimate-store-kit'));
			})
			.catch(() => setNotice(__('The combined files could not be cleared.', 'ultimate-store-kit')))
			.finally(() => setRegenerating(false));
	};

	const files = stats ? (stats.css || 0) + (stats.js || 0) : 0;

	const cell = 'px-5 py-4 max-[760px]:border-0 max-[760px]:border-t max-[760px]:border-solid max-[760px]:border-[#eef0f3]';
	const cellLabel = 'm-0 text-[11px] font-bold uppercase tracking-[.08em] text-[#8a8a93]';

	return (
		<div>
			<div className="mb-[18px]">
				<h1 className="m-0 text-[28px] font-extrabold tracking-[-.02em] text-[#0f1115]">{__('Asset Optimization', 'ultimate-store-kit')}</h1>
				<p className="m-0 mt-1.5 text-[13.5px] text-[#6c6c75]">
					{__('Load Ultimate Store Kit files only where they are used, and combine widget CSS and JS into files stored in your uploads folder.', 'ultimate-store-kit')}
				</p>
			</div>

			<section className="overflow-hidden rounded-card border border-solid border-[#e9e9ed] bg-white">
				<div className="flex items-center gap-4 px-5 py-5">
					<IconTile icon={GaugeIcon} accent={saved ? 'green' : 'teal'} size="xl" iconSize={20} />
					<div className="min-w-0 flex-1">
						<h2 className="m-0 text-[16px] font-bold text-[#0f1115]">{__('Asset Manager', 'ultimate-store-kit')}</h2>
						<p className="m-0 mt-1 max-w-[560px] text-[13px] leading-relaxed text-[#6c6c75]">
							{__('Joins the CSS and JS of the widgets each page uses into combined files, and skips the store-wide files on pages without an Ultimate Store Kit widget.', 'ultimate-store-kit')}
						</p>
					</div>
					<span title={saving ? __('Saving…', 'ultimate-store-kit') : undefined}>
						<Toggle checked={saved} disabled={saving} onChange={toggle} />
					</span>
				</div>

				<div className="grid grid-cols-3 border-0 border-t border-solid border-[#eef0f3] bg-[#fafbfc] max-[760px]:grid-cols-1">
					<div className={cell}>
						<p className={cellLabel}>{__('Status', 'ultimate-store-kit')}</p>
						<p className="m-0 mt-1.5 flex items-center gap-2 text-[13.5px] font-bold text-[#0f1115]">
							<span className={`h-2 w-2 rounded-full ${saved ? 'bg-[#22c55e]' : 'bg-[#a1a1aa]'}`} />
							{saved ? __('Enabled', 'ultimate-store-kit') : __('Disabled', 'ultimate-store-kit')}
						</p>
					</div>
					<div className={`${cell} border-0 border-l border-solid border-[#eef0f3] max-[760px]:border-l-0`}>
						<p className={cellLabel}>{__('Combined files', 'ultimate-store-kit')}</p>
						<p className="m-0 mt-1.5 text-[13.5px] font-bold text-[#0f1115]">
							{files
								? sprintf(
										/* translators: 1: CSS files, 2: JS files, 3: total size. */
										__('%1$d CSS · %2$d JS · %3$s', 'ultimate-store-kit'),
										stats.css || 0,
										stats.js || 0,
										formatBytes(stats.bytes)
								  )
								: '—'}
						</p>
						{stats && stats.version ? (
							<p className="m-0 mt-0.5 text-[11.5px] text-[#8a8a93]">
								{sprintf(/* translators: %s: short fingerprint of the current file set. */ __('Set %s', 'ultimate-store-kit'), stats.version)}
							</p>
						) : null}
					</div>
					<div className={`${cell} border-0 border-l border-solid border-[#eef0f3] max-[760px]:border-l-0`}>
						<p className={cellLabel}>{__('Auto-regenerate', 'ultimate-store-kit')}</p>
						<p className="m-0 mt-1.5 text-[12.5px] leading-relaxed text-[#52525b]">
							{__("Combined files rebuild by themselves after a plugin update or when Elementor's files are cleared.", 'ultimate-store-kit')}
						</p>
						<button
							type="button"
							onClick={regenerate}
							disabled={regenerating}
							className="mt-2 cursor-pointer rounded-full border border-solid border-[#e2e2e6] bg-white px-3 py-1.5 text-[12.5px] font-bold text-[#27272a] transition-colors hover:border-[#e30c1d] hover:text-[#e30c1d] disabled:cursor-wait disabled:opacity-60"
						>
							{regenerating ? __('Clearing…', 'ultimate-store-kit') : __('Regenerate files', 'ultimate-store-kit')}
						</button>
						{notice ? <p className="m-0 mt-2 text-[12px] text-[#15803d]" role="status">{notice}</p> : null}
					</div>
				</div>
			</section>

			<Card title={__('What changes when it is on', 'ultimate-store-kit')} className="mt-[14px]">
				<ul className="m-0 grid list-none grid-cols-3 gap-[10px] p-0 max-[900px]:grid-cols-1">
					{[
						{
							icon: ZapIcon,
							accent: 'green',
							title: __('Store-wide files only where needed', 'ultimate-store-kit'),
							text: __('The site stylesheet and script, the quick-view modal and the slide-in panel load only on pages with an Ultimate Store Kit widget.', 'ultimate-store-kit'),
						},
						{
							icon: LayersIcon,
							accent: 'violet',
							title: __('Fewer files per page', 'ultimate-store-kit'),
							text: __('The CSS and JS of the widgets on a page are joined into one stylesheet and one script, shared by every page with the same widgets.', 'ultimate-store-kit'),
						},
						{
							icon: CheckIcon,
							accent: 'blue',
							title: __('Editor unchanged', 'ultimate-store-kit'),
							text: __('The Elementor editor and preview keep loading the separate files, so editing works as before. Switch it off at any time to go back.', 'ultimate-store-kit'),
						},
					].map((item) => (
						<li key={item.title} className="m-0 flex gap-3 rounded-panel border border-solid border-[#ececf0] p-4">
							<IconTile icon={item.icon} accent={item.accent} size="md" iconSize={16} />
							<span>
								<span className="block text-[13.5px] font-bold text-[#0f1115]">{item.title}</span>
								<span className="mt-1 block text-[12.5px] leading-relaxed text-[#6c6c75]">{item.text}</span>
							</span>
						</li>
					))}
				</ul>
			</Card>
		</div>
	);
};

export default PerformancePage;
