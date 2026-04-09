import { __ } from '@wordpress/i18n';
import Icon from './Icon';
import { CloseIcon, SparklesIcon } from '../icons';
import {
	buildSidebarSections,
	getAdminBarHeight,
	groupHeadingClass,
	navItems,
} from '../utils';

const Sidebar = ({
	activePage,
	onNavigate,
	isPro,
	isProPluginActive,
	isOpen,
	isDesktop,
	onClose,
	settingsGroups = [],
}) => {
	const sections = buildSidebarSections({
		items: navItems,
		isPro,
		isProPluginActive,
		settingsGroups,
	});

	const content = (
		<>
			<nav className="flex flex-col gap-6" aria-label="Main">
				{sections.map((section) => (
					<div key={section.group}>
						<p className={`m-0 ${groupHeadingClass}`}>{section.group}</p>
						<ul className="m-0 list-none space-y-1 p-0">
							{section.items
								.filter((item) => !(isPro && item.id === 'get-pro'))
								.map((item) => {
									const isActive = activePage === item.id;
									return (
										<li key={item.id}>
											<button
												type="button"
												onClick={() => {
													onNavigate(item.id);
													window.location.hash = `#${item.id}`;
													onClose();
												}}
												className={`flex w-full cursor-pointer items-center gap-3 rounded-lg border-0 px-3 py-3 text-left text-sm font-medium transition-colors ${
													isActive
														? 'bg-uks-brand text-white shadow-sm'
														: 'bg-transparent text-slate-700 hover:bg-gray-100 hover:text-slate-900'
												}`}
											>
												<Icon name={item.icon} />
												<span className="flex-1">{item.label}</span>
												{item.badge && (
													<span
														className="shrink-0 whitespace-nowrap rounded-md border border-solid px-1.5 py-0.5 text-[9px] font-bold"
														style={{
															borderColor: isActive
																? 'rgba(255,255,255,0.4)'
																: '#e5e7eb',
															color: isActive ? '#fff' : '#6b7280',
															background: isActive
																? 'rgba(255,255,255,0.18)'
																: 'transparent',
														}}
													>
														{item.badge}
													</span>
												)}
											</button>
										</li>
									);
								})}
						</ul>
					</div>
				))}
			</nav>
			<div className="mt-6 hidden rounded-xl bg-slate-100 p-4 lg:block lg:mt-8">
				<span className="mb-2.5 flex items-center gap-2 text-base font-bold text-slate-800">
					<SparklesIcon className="w-5 h-5" />
					{__('Coming soon', 'ultimate-store-kit')}
				</span>
				<p className="m-0 text-[12px] leading-relaxed text-slate-600">
					{__(
						'New items planned for upcoming updates:',
						'ultimate-store-kit'
					)}
				</p>
				<ul className="mt-2.5 m-0 space-y-1.5 p-0 text-[12px] text-slate-600">
					<li className="flex items-start gap-2">
						<span className="mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand" />
						{__('7+ WooCommerce widgets', 'ultimate-store-kit')}
					</li>
					<li className="flex items-start gap-2">
						<span className="mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand" />
						{__('Template-based presets', 'ultimate-store-kit')}
					</li>
					<li className="flex items-start gap-2">
						<span className="mt-1 h-1.5 w-1.5 rounded-full bg-uks-brand" />
						{__('Performance-focused improvements', 'ultimate-store-kit')}
					</li>
				</ul>
				<button
					onClick={() =>
						window.open(
							'https://feedback.bdthemes.com/b/6vr2250l/feature-requests',
							'_blank'
						)
					}
					type="button"
					className="mt-3 inline-flex cursor-pointer items-center rounded-lg border border-uks-brand bg-white px-3 py-1.5 text-[12px] font-semibold text-uks-brand transition-colors hover:bg-uks-brand hover:text-white"
				>
					{__('See roadmap', 'ultimate-store-kit')}
				</button>
			</div>
		</>
	);

	if (isDesktop) {
		return (
			<div
				style={{ display: 'flex' }}
				className="w-64 shrink-0 flex-col justify-between self-stretch rounded-lg border border-solid border-gray-100 bg-white px-4 py-6 lg:sticky lg:top-[7.5rem]"
			>
				{content}
			</div>
		);
	}

	const adminBarH = getAdminBarHeight();

	return (
		<>
			{isOpen && (
				<div
					style={{
						display: 'block',
						position: 'fixed',
						top: adminBarH,
						left: 0,
						right: 0,
						bottom: 0,
						zIndex: 99998,
						backgroundColor: 'rgba(0,0,0,0.3)',
					}}
					onClick={onClose}
					aria-hidden="true"
				/>
			)}
			<div
				style={{
					position: 'fixed',
					left: 0,
					top: adminBarH,
					zIndex: 99999,
					height: `calc(100vh - ${adminBarH}px)`,
					width: '86vw',
					maxWidth: '320px',
					display: 'flex',
					flexDirection: 'column',
					backgroundColor: '#fff',
					padding: '1rem',
					boxShadow: '4px 0 24px rgba(0,0,0,0.15)',
					transform: isOpen ? 'translateX(0)' : 'translateX(-100%)',
					transition: 'transform 300ms ease-out',
					pointerEvents: isOpen ? 'auto' : 'none',
					overflowY: 'auto',
				}}
			>
				<div className="mb-3 flex items-center justify-between">
					<p className="m-0 text-sm font-bold text-slate-700">
						{__('Navigation', 'ultimate-store-kit')}
					</p>
					<button
						type="button"
						onClick={onClose}
						className="inline-flex h-8 w-8 cursor-pointer items-center justify-center rounded-md border border-slate-200 bg-white text-slate-500 hover:text-slate-700"
						aria-label={__('Close menu', 'ultimate-store-kit')}
					>
						<CloseIcon className="h-4 w-4" />
					</button>
				</div>
				{content}
			</div>
		</>
	);
};

export default Sidebar;

