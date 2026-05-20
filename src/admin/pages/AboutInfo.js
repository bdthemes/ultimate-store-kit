import { __ } from '@wordpress/i18n';
import {
	BookIcon,
	EditIcon,
	FacebookIcon,
	GlobeIcon,
	MessageIcon,
	StarIcon,
	UserIcon,
	UskLogo,
	VideoPanelIcon,
} from '../icons';

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
					<div className="flex max-w-3xl flex-col items-start gap-4 text-left sm:flex-row">
						<div className="">
							<UskLogo className="w-12 h-12 block" />
						</div>
						<div className="min-w-0 flex-1">
							<div className="mb-2 flex flex-wrap items-center justify-start gap-2">
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
							<ul className="m-0 flex list-none flex-wrap justify-start gap-3 p-0">
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
						icon={<UserIcon />}
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
						icon={<GlobeIcon />}
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
						icon={<BookIcon />}
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
						icon={<MessageIcon />}
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
							<VideoPanelIcon />,
						],
						[
							'https://feedback.bdthemes.com/b/6vr2250l/feature-requests/',
							__('Request a feature', 'ultimate-store-kit'),
							__(
								'Share ideas and vote on what we build next.',
								'ultimate-store-kit'
							),
							<EditIcon />,
						],
						[
							'https://wordpress.org/plugins/ultimate-store-kit/',
							__('Rate us on WordPress.org', 'ultimate-store-kit'),
							__(
								'Help others discover the plugin with a review.',
								'ultimate-store-kit'
							),
							<StarIcon className="h-5 w-5" />,
						],
						[
							'https://www.facebook.com/groups/358290584725185',
							__('Facebook community', 'ultimate-store-kit'),
							__(
								'Join our Facebook community to connect with other users and the team.',
								'ultimate-store-kit'
							),
							<FacebookIcon />,
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
