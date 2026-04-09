const baseProps = {
	xmlns: 'http://www.w3.org/2000/svg',
	fill: 'none',
	stroke: 'currentColor',
	strokeWidth: 2,
	strokeLinecap: 'round',
	strokeLinejoin: 'round',
};

export const UskLogo = ({ className = 'block h-10 w-10 sm:h-12 sm:w-12' }) => (
	<svg
		className={className}
		version="1.1"
		id="Layer_1"
		xmlns="http://www.w3.org/2000/svg"
		xmlnsXlink="http://www.w3.org/1999/xlink"
		x="0px"
		y="0px"
		viewBox="0 0 500 500"
		style={{ enableBackground: 'new 0 0 500 500' }}
		xmlSpace="preserve"
	>
		<style
			type="text/css"
			dangerouslySetInnerHTML={{
				__html:
					'\n\t.st0{fill:#E30C1D;enable-background:new    ;}\n\t.st1{fill:#FFFFFF;}\n',
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
);

export const CloseIcon = ({ className = 'h-4 w-4' }) => (
	<svg {...baseProps} viewBox="0 0 24 24" className={className}>
		<path d="M18 6 6 18" />
		<path d="m6 6 12 12" />
	</svg>
);

export const MenuIcon = ({ className = 'h-4 w-4' }) => (
	<svg {...baseProps} viewBox="0 0 24 24" className={className}>
		<path d="M4 6h16" />
		<path d="M4 12h16" />
		<path d="M4 18h16" />
	</svg>
);

export const SupportIcon = ({ className = 'h-4 w-4 block' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
		<path d="M21 16v2a4 4 0 0 1-4 4h-5" />
	</svg>
);

export const SparklesIcon = ({ className = 'w-5 h-5' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M12 2v4" />
		<path d="m16.2 7.8 2.9-2.9" />
		<path d="M18 12h4" />
		<path d="m16.2 16.2 2.9 2.9" />
		<path d="M12 18v4" />
		<path d="m4.9 19.1 2.9-2.9" />
		<path d="M2 12h4" />
		<path d="m4.9 4.9 2.9 2.9" />
	</svg>
);

export const StarIcon = ({ className = 'w-4 h-4 block' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
	</svg>
);
export const FilledStarIcon = ({ className = 'w-4 h-4 block' }) => (
	<svg className={className} viewBox="0 0 24 24" fill="currentColor">
		<path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
	</svg>
);

const navClass = 'h-5 w-5 block color-current';

export const HomeIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
		<path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
	</svg>
);
export const GridIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<rect width={7} height={9} x={3} y={3} rx={1} />
		<rect width={7} height={5} x={14} y={3} rx={1} />
		<rect width={7} height={9} x={14} y={12} rx={1} />
		<rect width={7} height={5} x={3} y={16} rx={1} />
	</svg>
);
export const CurrencySwitcherIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<circle cx="12" cy="12" r="10" />
		<path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
		<path d="M12 18V6" />
	</svg>
);
export const VariationSwatchesIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
		<circle cx="7.5" cy="10.5" r=".5" fill="currentColor" stroke="none" />
		<circle cx="12" cy="7.5" r=".5" fill="currentColor" stroke="none" />
		<circle cx="16.5" cy="10.5" r=".5" fill="currentColor" stroke="none" />
		<circle cx="9" cy="15.5" r=".5" fill="currentColor" stroke="none" />
	</svg>
);
export const BadgeIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z" />
		<circle cx="16.5" cy="7.5" r=".5" fill="currentColor" />
	</svg>
);
export const WoocommerceIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M15 21v-5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v5" />
		<path d="M17.774 10.31a1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.451 0 1.12 1.12 0 0 0-1.548 0 2.5 2.5 0 0 1-3.452 0 1.12 1.12 0 0 0-1.549 0 2.5 2.5 0 0 1-3.77-3.248l2.889-4.184A2 2 0 0 1 7 2h10a2 2 0 0 1 1.653.873l2.895 4.192a2.5 2.5 0 0 1-3.774 3.244" />
		<path d="M4 10.95V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8.05" />
	</svg>
);
export const EddIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
		<path d="m7.5 4.21 4.5 2.6 4.5-2.6" />
		<path d="M12 17.5V12" />
	</svg>
);
export const InfoIcon = ({ className = navClass }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<circle cx={12} cy={12} r={10} />
		<path d="M12 16v-4" />
		<path d="M12 8h.01" />
	</svg>
);

export const SearchIcon = ({ className = 'h-4 w-4 block' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="m21 21-4.34-4.34" />
		<circle cx={11} cy={11} r={8} />
	</svg>
);

export const CheckIcon = ({ className = 'h-4 w-4' }) => (
	<svg {...baseProps} viewBox="0 0 24 24" className={className}>
		<path d="M20 6 9 17l-5-5" />
	</svg>
);

export const EyeIcon = ({ className = 'h-4 w-4 block' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
		<circle cx={12} cy={12} r={3} />
	</svg>
);

export const PlayIcon = ({ className = 'h-4 w-4 block' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z" />
	</svg>
);

export const LinkPluginIcon = ({ className = 'h-4 w-4 block' }) => (
	<svg {...baseProps} width={24} height={24} viewBox="0 0 24 24" className={className}>
		<path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z" />
		<path d="m2 22 3-3" />
		<path d="M7.5 13.5 10 11" />
		<path d="M10.5 16.5 13 14" />
		<path d="m18 3-4 4h6l-4 4" />
	</svg>
);

export const LockIcon = ({ className = 'h-7 w-7', stroke = 'currentColor' }) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width={28}
		height={28}
		viewBox="0 0 24 24"
		fill="none"
		stroke={stroke}
		strokeWidth={2}
		strokeLinecap="round"
		strokeLinejoin="round"
		className={className}
	>
		<rect width={18} height={11} x={3} y={11} rx={2} ry={2} />
		<path d="M7 11V7a5 5 0 0 1 10 0v4" />
	</svg>
);

export const UserIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
		<circle cx="12" cy="7" r="4" />
	</svg>
);
export const GlobeIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<circle cx="12" cy="12" r="10" />
		<path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
	</svg>
);
export const BookIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
		<path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
	</svg>
);
export const MessageIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
	</svg>
);
export const VideoPanelIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<polygon points="23 7 16 12 23 17 23 7" />
		<rect x="1" y="5" width="15" height="14" rx="2" ry="2" />
	</svg>
);
export const EditIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<path d="M12 20h9" />
		<path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
	</svg>
);
export const FacebookIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
	</svg>
);
export const LiveVisitorCountIcon = ({ className = 'h-5 w-5' }) => (
	<svg {...baseProps} className={className} viewBox="0 0 24 24">
		<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
		<circle cx="9" cy="7" r="4" />
		<path d="M23 21v-2a4 4 0 0 0-3-3.87" />
		<path d="M16 3.13a4 4 0 0 1 0 7.75" />
	</svg>
);

export const adminIconMap = {
	home: HomeIcon,
	grid: GridIcon,
	'currency-switcher': CurrencySwitcherIcon,
	'variation-swatches': VariationSwatchesIcon,
	settings: GridIcon,
	badge: BadgeIcon,
	star: StarIcon,
	woocommerce: WoocommerceIcon,
	edd: EddIcon,
	other: GridIcon,
	info: InfoIcon,
	'live-visitor-count': LiveVisitorCountIcon,
};
