import { __ } from '@wordpress/i18n';
import { btnPrimary, btnSm, btnSecondary } from '../tw';
import { CloseIcon, MenuIcon, StarIcon, SupportIcon, UskLogo } from '../icons';

const HELP_URL = 'https://bdthemes.com/support/';
const PRO_URL = 'https://storekit.pro/pricing/';

const Header = ({ version, isPro, onToggleSidebar, isSidebarOpen, isDesktop }) => {
	return (
		<div className="rounded-tl-lg rounded-tr-lg border-0 border-b border-solid border-b-gray-100 bg-white px-4 py-3 sm:px-6 sm:py-4">
			<div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
				<div className="flex min-w-0 items-center gap-3 sm:gap-4">
					<div className="flex">
						<UskLogo />
					</div>
					<div className="flex min-w-0 flex-col gap-1">
						<div className="flex flex-wrap items-center gap-2">
							<h1 className="m-0 text-lg font-bold leading-tight text-slate-800 sm:text-xl">
								{__('Ultimate Store Kit', 'ultimate-store-kit')}
							</h1>
							{version ? (
								<span className="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
									v{version}
								</span>
							) : null}
						</div>
						<p className="m-0 max-w-xl text-[13px] leading-snug text-gray-500 sm:text-sm">
							{__(
								'Build high-converting WooCommerce stores with Elementor widgets & presets.',
								'ultimate-store-kit'
							)}
						</p>
					</div>
				</div>
				<div className="flex shrink-0 flex-wrap items-center gap-2">
					<button
						type="button"
						onClick={(e) => onToggleSidebar?.(e)}
						className="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-md border border-slate-200 bg-white text-slate-700 transition-colors hover:border-uks-brand/40 hover:text-uks-brand"
						style={{ display: isDesktop ? 'none' : 'inline-flex' }}
						aria-expanded={isSidebarOpen ? 'true' : 'false'}
						aria-label={__('Open menu', 'ultimate-store-kit')}
					>
						{isSidebarOpen ? (
							<CloseIcon className="h-4 w-4" />
						) : (
							<MenuIcon className="h-4 w-4" />
						)}
					</button>
					{!isPro ? (
						<a
							href={PRO_URL}
							target="_blank"
							rel="noopener noreferrer"
							className={`${btnSm} ${btnPrimary}`}
						>
							<StarIcon className="w-4 h-4 block" />

							{__('Get Pro', 'ultimate-store-kit')}
						</a>
					) : null}
					<a
						href={HELP_URL}
						target="_blank"
						rel="noopener noreferrer"
						className={`${btnSm} ${btnSecondary} flex items-center gap-2 hover:border-uks-brand/40 hover:bg-white hover:text-uks-brand`}
					>
						<span
							className="flex h-4 w-4 items-center justify-center rounded-full border border-current text-inherit"
							aria-hidden="true"
						>
							<SupportIcon className="w-4 h-4 block" />

						</span>
						{__('Help & Support', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default Header;
