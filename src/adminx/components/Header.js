import { __ } from '@wordpress/i18n';

const Header = ({ version, isPro }) => {
	const helpUrl =
		'https://bdthemes.com/knowledge-base/ultimate-store-kit/';
	const proUrl = 'https://bdthemes.com/ultimate-store-kit/pricing/';

	return (
		<div className="sticky top-8 z-[100] border-b border-gray-200 bg-white px-6 py-4">
			<div className="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
				<div className="flex min-w-0 gap-4">
					<div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-blue-600">
						<svg
							className="h-6 w-6 text-white"
							viewBox="0 0 24 24"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
							aria-hidden="true"
						>
							<path
								d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h10v2H4v-2z"
								fill="currentColor"
								opacity="0.9"
							/>
							<path
								d="M17 14l3 3-3 3"
								stroke="currentColor"
								strokeWidth="2"
								strokeLinecap="round"
								strokeLinejoin="round"
							/>
						</svg>
					</div>
					<div className="flex min-w-0 flex-col gap-1">
						<div className="flex flex-wrap items-center gap-2">
							<h1 className="m-0 text-xl font-bold leading-tight text-slate-800">
								{__('Ultimate Store Kit', 'ultimate-store-kit')}
							</h1>
							{version ? (
								<span className="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
									v{version}
								</span>
							) : null}
						</div>
						<p className="m-0 max-w-xl text-sm leading-snug text-gray-500">
							{__(
								'Build high-converting WooCommerce stores with Elementor widgets, presets, and store-focused tools.',
								'ultimate-store-kit'
							)}
						</p>
					</div>
				</div>
				<div className="flex shrink-0 flex-wrap items-center gap-3 sm:pt-1">
					{!isPro ? (
						<a
							href={proUrl}
							target="_blank"
							rel="noopener noreferrer"
							className="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition-colors hover:border-blue-300 hover:text-blue-600"
						>
							<span
								className="dashicons dashicons-star-filled text-base text-amber-500"
								aria-hidden="true"
							/>
							{__('Get Pro', 'ultimate-store-kit')}
						</a>
					) : null}
					<a
						href={helpUrl}
						target="_blank"
						rel="noopener noreferrer"
						className="inline-flex items-center gap-1.5 text-sm text-gray-600 transition-colors hover:text-blue-600"
					>
						<span
							className="flex h-5 w-5 items-center justify-center rounded-full border border-gray-300 text-[11px] font-bold leading-none text-gray-500"
							aria-hidden="true"
						>
							?
						</span>
						{__('Help & Support', 'ultimate-store-kit')}
					</a>
				</div>
			</div>
		</div>
	);
};

export default Header;
