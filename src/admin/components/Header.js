import { __ } from '@wordpress/i18n';
import { btnPrimary, btnSm, btnSecondary } from '../tw';

const Header = ({ version, isPro, onToggleSidebar, isSidebarOpen, isDesktop }) => {
	const helpUrl =
		'https://bdthemes.com/support/';
	const proUrl = 'https://storekit.pro/pricing/';

	return (
		<div className="rounded-tl-lg rounded-tr-lg border-0 border-b border-solid border-b-gray-100 bg-white px-4 py-3 sm:px-6 sm:py-4">
			<div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
				<div className="flex min-w-0 items-center gap-3 sm:gap-4">
					<div className="flex">
						<svg
							className="block h-10 w-10 sm:h-12 sm:w-12"
							version="1.1"
							id="Layer_1"
							xmlns="http://www.w3.org/2000/svg"
							xmlnsXlink="http://www.w3.org/1999/xlink"
							x="0px"
							y="0px"
							viewBox="0 0 500 500"
							style={{ enableBackground: "new 0 0 500 500" }}
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
								d="M473.6,496.4h-447c-12.6,0-22.9-10.2-22.9-22.9v-447c0-12.4,10.2-22.9,22.9-22.9h446.8
	c12.6,0,22.9,10.2,22.9,22.9v446.8C496.3,486.3,486.2,496.4,473.6,496.4z"
							/>
							<g>
								<path
									className="st1"
									d="M374.3,364l-21.1-157.6c-1.9-14.3-14.2-25-28.6-25c0,0-0.1,0-0.1,0l-143.7,0.7c-14.5,0.1-26.8,11-28.5,25.4
		l-18.6,156.9c-1,8.2,1.6,16.4,7.1,22.5s13.3,9.7,21.5,9.7h183.5c8.3,0,16.2-3.6,21.7-9.8C372.9,380.6,375.4,372.3,374.3,364z
		 M186.4,217.1l132.8-0.6l6.4,47.6c-34.1,4.4-61,23.4-78.4,55.7c-8.5,15.8-12.9,31.5-15,41.9h-63L186.4,217.1z M268.1,361.7
		c1.9-7.3,5-16.3,9.9-25.3c12-22.3,29.2-34.7,52.2-37.6l8.4,62.9H268.1z"
								/>
								<path
									className="st1"
									d="M212.4,169.2c8.8,0,16-7.2,16-16c0-13.9,11.3-25.3,25.3-25.3c13.9,0,25.3,11.3,25.3,25.3c0,8.8,7.2,16,16,16
		s16-7.2,16-16c0-31.6-25.7-57.3-57.3-57.3c-31.6,0-57.3,25.7-57.3,57.3C196.4,162.1,203.6,169.2,212.4,169.2z"
								/>
							</g>
						</svg>
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
							<svg
								xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth={2}
								strokeLinecap="round"
								strokeLinejoin="round"
								className="h-4 w-4"
							>
								<path d="M18 6 6 18" />
								<path d="m6 6 12 12" />
							</svg>
						) : (
							<svg
								xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth={2}
								strokeLinecap="round"
								strokeLinejoin="round"
								className="h-4 w-4"
							>
								<path d="M4 6h16" />
								<path d="M4 12h16" />
								<path d="M4 18h16" />
							</svg>
						)}
					</button>
					{!isPro ? (
						<a
							href={proUrl}
							target="_blank"
							rel="noopener noreferrer"
							className={`${btnSm} ${btnPrimary}`}
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width={24}
								height={24}
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth={2}
								strokeLinecap="round"
								strokeLinejoin="round"
								className="w-4 h-4 block"
							>
								<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
							</svg>

							{__('Get Pro', 'ultimate-store-kit')}
						</a>
					) : null}
					<a
						href={helpUrl}
						target="_blank"
						rel="noopener noreferrer"
						className={`${btnSm} ${btnSecondary} flex items-center gap-2 hover:border-uks-brand/40 hover:bg-white hover:text-uks-brand`}
					>
						<span
							className="flex h-4 w-4 items-center justify-center rounded-full border border-current text-inherit"
							aria-hidden="true"
						>
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width={24}
								height={24}
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth={2}
								strokeLinecap="round"
								strokeLinejoin="round"
								className="w-4 h-4 block"
							>
								<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
								<path d="M21 16v2a4 4 0 0 1-4 4h-5" />
							</svg>

						</span>
						{__('Help & Support', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default Header;
