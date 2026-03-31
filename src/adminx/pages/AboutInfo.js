import { __ } from '@wordpress/i18n';

const adminData = window.ultimateStoreKitAdminData || {};

const linkStrong =
	'font-semibold text-uks-brand no-underline transition hover:underline';

const InfoCard = ({ icon, label, children }) => (
	<div className="group flex items-center gap-4 rounded-lg border border-solid border-gray-200 bg-white p-4">
		<div
			className="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-uks-brand/10 text-uks-brand transition group-hover:bg-uks-brand/15"
			aria-hidden="true"
		>
			{icon}
		</div>
		<div className="min-w-0 flex-1">
			<h3 className="m-0 mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
				{label}
			</h3>
			<div className="text-sm font-semibold text-slate-800">{children}</div>
		</div>
	</div>
);

const UsefulLinkCard = ({ icon, title, desc, href }) => (
	<a
		href={href}
		target="_blank"
		rel="noopener noreferrer"
		className="group flex items-center gap-4 rounded-lg border border-solid border-gray-200 bg-white p-4 text-inherit no-underline transition hover:border-uks-brand/25"
	>
		<div
			className="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-uks-brand/10 text-uks-brand transition group-hover:bg-uks-brand/15"
			aria-hidden="true"
		>
			{icon}
		</div>
		<div className="min-w-0 flex-1">
			<div className="text-sm font-semibold text-slate-800">{title}</div>
			<p className="m-0 mt-0.5 text-[12px] leading-snug text-slate-500">{desc}</p>
		</div>
	</a>
);

const AboutInfo = () => {
	const isPro = Boolean(adminData.isPro);
	const version = adminData.version || '';

	return (
		<div className="space-y-6">
			<div className="overflow-hidden rounded-usk border border-slate-200 bg-white">
				<div className="bg-white p-4 sm:p-5 border border-solid border-gray-100">
					<div className="flex gap-4 max-w-3xl flex-col items-center text-center sm:flex-row sm:items-start sm:text-left">
						<div className="">
							<svg
								className="w-12 h-12 block"
								version="1.1"
								id="Layer_1"
								xmlns="http://www.w3.org/2000/svg"
								xmlnsXlink="http://www.w3.org/1999/xlink"
								x="0px"
								y="0px"
								viewBox="0 0 500 500"
								xmlSpace="preserve"
							>
								<style
									type="text/css"
									dangerouslySetInnerHTML={{
										__html:
											"\n\t.st0{fill:#E30C1D;enable-background:new    ;}\n\t.st1{fill:#FFFFFF;}\n"
									}}
								/>
								<path
									className="st0"
									d="M473.6,496.4h-447c-12.6,0-22.9-10.2-22.9-22.9v-447c0-12.4,10.2-22.9,22.9-22.9h446.8 c12.6,0,22.9,10.2,22.9,22.9v446.8C496.3,486.3,486.2,496.4,473.6,496.4z"
								/>
								<g>
									<path
										className="st1"
										d="M374.3,364l-21.1-157.6c-1.9-14.3-14.2-25-28.6-25c0,0-0.1,0-0.1,0l-143.7,0.7c-14.5,0.1-26.8,11-28.5,25.4 l-18.6,156.9c-1,8.2,1.6,16.4,7.1,22.5s13.3,9.7,21.5,9.7h183.5c8.3,0,16.2-3.6,21.7-9.8C372.9,380.6,375.4,372.3,374.3,364z M186.4,217.1l132.8-0.6l6.4,47.6c-34.1,4.4-61,23.4-78.4,55.7c-8.5,15.8-12.9,31.5-15,41.9h-63L186.4,217.1z M268.1,361.7 c1.9-7.3,5-16.3,9.9-25.3c12-22.3,29.2-34.7,52.2-37.6l8.4,62.9H268.1z"
									/>
									<path
										className="st1"
										d="M212.4,169.2c8.8,0,16-7.2,16-16c0-13.9,11.3-25.3,25.3-25.3c13.9,0,25.3,11.3,25.3,25.3c0,8.8,7.2,16,16,16 s16-7.2,16-16c0-31.6-25.7-57.3-57.3-57.3c-31.6,0-57.3,25.7-57.3,57.3C196.4,162.1,203.6,169.2,212.4,169.2z"
									/>
								</g>
							</svg>
						</div>
						<div className="min-w-0 flex-1">
							<div className="mb-2 flex flex-wrap items-center justify-center gap-2 sm:justify-start">
								<h3 className="m-0 text-[22px] font-extrabold leading-none text-slate-900">
									{__('Ultimate Store Kit', 'ultimate-store-kit')}
								</h3>
								<span className="inline-flex items-center rounded-full bg-uks-brand px-2.5 py-0.5 text-xs font-semibold text-white">
									v{version}
								</span>
								<span
									className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${isPro
											? 'bg-emerald-100 text-emerald-800'
											: 'bg-slate-200 text-slate-700'
										}`}
								>
									{isPro
										? __('Pro', 'ultimate-store-kit')
										: __('Free', 'ultimate-store-kit')}
								</span>
							</div>
							<p className="mb-4 text-[13px] leading-relaxed text-slate-600">
								{__(
									'Build online stores in WordPress with the powerful store builder addon for Elementor. Enjoy a wide range of customizations and easily build product grids, carousels, single product/page elements, checkouts and more.',
									'ultimate-store-kit'
								)}
							</p>
							<ul className="m-0 flex list-none flex-wrap justify-center gap-3 p-0 sm:justify-start">
								<li className="rounded-full py-1 px-2 border border-solid border-slate-200 bg-white/80 text-xs font-medium text-slate-600">
									{__('Elementor widgets', 'ultimate-store-kit')}
								</li>
								<li className="rounded-full py-1 px-2 border border-solid border-slate-200 bg-white/80 text-xs font-medium text-slate-600">
									{__('WooCommerce ready', 'ultimate-store-kit')}
								</li>
								<li className="rounded-full py-1 px-2 border border-solid border-slate-200 bg-white/80 text-xs font-medium text-slate-600">
									{__('Store-focused UI', 'ultimate-store-kit')}
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div className="grid grid-cols-1 gap-px border-t border-slate-200 sm:grid-cols-3">
					<div className="bg-gray-100 px-4 py-3 text-center sm:text-left">
						<p className="m-0 mb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400">
							{__('Current version', 'ultimate-store-kit')}
						</p>
						<p className="m-0 text-sm font-bold text-slate-800">v{version}</p>
					</div>
					<div className="bg-gray-100 px-4 py-3 text-center sm:text-left">
						<p className="m-0 mb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400">
							{__('License', 'ultimate-store-kit')}
						</p>
						<p className="m-0 text-sm font-bold text-slate-800">
							{isPro
								? __('Pro (active)', 'ultimate-store-kit')
								: __('Free', 'ultimate-store-kit')}
						</p>
					</div>
					<div className="bg-gray-100 px-4 py-3 text-center sm:text-left">
						<p className="m-0 mb-0.5 text-[11px] font-semibold uppercase tracking-wide text-slate-400">
							{__('Built for', 'ultimate-store-kit')}
						</p>
						<p className="m-0 text-sm font-bold text-slate-800">
							{__('WordPress + WooCommerce', 'ultimate-store-kit')}
						</p>
					</div>
				</div>
			</div>

		<div className="rounded-usk border border-solid border-gray-100 bg-white p-4 sm:p-5">
			<h3 className="m-0 mb-3 text-base font-bold text-slate-800">
				{__('Product & support', 'ultimate-store-kit')}
			</h3>
			<div className="grid grid-cols-1 gap-3 sm:grid-cols-2 2xl:grid-cols-4">
					<InfoCard
						label={__('Author', 'ultimate-store-kit')}
						icon={
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
								<circle cx="12" cy="7" r="4" />
							</svg>
						}
					>
						<a
							href="https://bdthemes.com/"
							target="_blank"
							rel="noopener noreferrer"
							className={linkStrong}
						>
							BdThemes
						</a>
					</InfoCard>
					<InfoCard
						label={__('Website', 'ultimate-store-kit')}
						icon={
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<circle cx="12" cy="12" r="10" />
								<path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
							</svg>
						}
					>
						<a
							href="https://storekit.pro/"
							target="_blank"
							rel="noopener noreferrer"
							className={linkStrong}
						>
							storekit.pro
						</a>
					</InfoCard>
					<InfoCard
						label={__('Documentation', 'ultimate-store-kit')}
						icon={
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
								<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
							</svg>
						}
					>
						<a
							href="https://bdthemes.com/all-knowledge-base-of-ultimate-store-kit/"
							target="_blank"
							rel="noopener noreferrer"
							className={linkStrong}
						>
							{__('Knowledge Base', 'ultimate-store-kit')}
						</a>
					</InfoCard>
					<InfoCard
						label={__('Support', 'ultimate-store-kit')}
						icon={
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
							</svg>
						}
					>
						<a
							href="https://bdthemes.com/support/"
							target="_blank"
							rel="noopener noreferrer"
							className={linkStrong}
						>
							{__('Get Support', 'ultimate-store-kit')}
						</a>
					</InfoCard>
				</div>
			</div>

		<div className="rounded-usk border border-solid border-gray-100 bg-white p-4 sm:p-5">
			<h3 className="m-0 mb-3 text-base font-bold text-slate-800">
				{__('Useful links', 'ultimate-store-kit')}
			</h3>
				<ul className="m-0 grid list-none grid-cols-1 gap-3 p-0 sm:grid-cols-2 2xl:grid-cols-4">
					{[
						[
							'https://www.youtube.com/c/bdthemes',
							__('Video tutorials', 'ultimate-store-kit'),
							__(
								'Step-by-step YouTube tutorials for setup, widgets, and customization.',
								'ultimate-store-kit'
							),
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<polygon points="23 7 16 12 23 17 23 7" />
								<rect x="1" y="5" width="15" height="14" rx="2" ry="2" />
							</svg>,
						],
						[
							'https://feedback.bdthemes.com/b/6vr2250l/feature-requests/',
							__('Request a feature', 'ultimate-store-kit'),
							__(
								'Share ideas and vote on what we build next.',
								'ultimate-store-kit'
							),
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<path d="M12 20h9" />
								<path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
							</svg>,
						],
						[
							'https://wordpress.org/plugins/ultimate-store-kit/',
							__('Rate us on WordPress.org', 'ultimate-store-kit'),
							__(
								'Help others discover the plugin with a review.',
								'ultimate-store-kit'
							),
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
							</svg>,
						],
						[
							'https://www.facebook.com/groups/358290584725185',
							__('Facebook community', 'ultimate-store-kit'),
							__(
								'Join our Facebook community to connect with other users and the team.',
								'ultimate-store-kit'
							),
							<svg className="h-5 w-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24">
								<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
							</svg>,
						],
					].map(([href, title, desc, icon]) => (
						<li key={href}>
							<UsefulLinkCard
								href={href}
								title={title}
								desc={desc}
								icon={icon}
							/>
						</li>
					))}
				</ul>
			</div>
		</div>
	);
};

export default AboutInfo;
