/**
 * Line icons for the dashboard shell (Element Pack style: 24px grid, 2px
 * stroke, round caps). Every icon takes `size` and an optional `className`.
 */

const Svg = ({ size = 18, className = '', children, strokeWidth = 2 }) => (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width={size}
		height={size}
		viewBox="0 0 24 24"
		fill="none"
		stroke="currentColor"
		strokeWidth={strokeWidth}
		strokeLinecap="round"
		strokeLinejoin="round"
		className={`block shrink-0 ${className}`}
		aria-hidden="true"
		focusable="false"
	>
		{children}
	</svg>
);

export const DashboardIcon = (p) => (
	<Svg {...p}>
		<rect x="3" y="3" width="7" height="9" rx="1" />
		<rect x="14" y="3" width="7" height="5" rx="1" />
		<rect x="14" y="12" width="7" height="9" rx="1" />
		<rect x="3" y="16" width="7" height="5" rx="1" />
	</Svg>
);

export const WidgetsIcon = (p) => (
	<Svg {...p}>
		<rect x="3" y="3" width="7" height="7" rx="1" />
		<rect x="14" y="3" width="7" height="7" rx="1" />
		<rect x="3" y="14" width="7" height="7" rx="1" />
		<rect x="14" y="14" width="7" height="7" rx="1" />
	</Svg>
);

export const ModulesIcon = (p) => (
	<Svg {...p}>
		<path d="M15.39 4.39a1 1 0 0 0 1.68-.474 2.5 2.5 0 1 1 3.014 3.015 1 1 0 0 0-.474 1.68l1.683 1.682a2.414 2.414 0 0 1 0 3.414L19.61 15.39a1 1 0 0 1-1.68-.474 2.5 2.5 0 1 0-3.014 3.015 1 1 0 0 1 .474 1.68l-1.683 1.682a2.414 2.414 0 0 1-3.414 0L8.61 19.61a1 1 0 0 0-1.68.474 2.5 2.5 0 1 1-3.014-3.015 1 1 0 0 0 .474-1.68l-1.683-1.682a2.414 2.414 0 0 1 0-3.414L4.39 8.61a1 1 0 0 1 1.68.474 2.5 2.5 0 1 0 3.014-3.015 1 1 0 0 1-.474-1.68l1.683-1.682a2.414 2.414 0 0 1 3.414 0z" />
	</Svg>
);

export const TemplateIcon = (p) => (
	<Svg {...p}>
		<rect x="3" y="3" width="18" height="18" rx="2" />
		<path d="M3 9h18" />
		<path d="M9 21V9" />
	</Svg>
);

export const KeyIcon = (p) => (
	<Svg {...p}>
		<path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4" />
		<path d="m21 2-9.6 9.6" />
		<circle cx="7.5" cy="15.5" r="5.5" />
	</Svg>
);

export const ZapIcon = (p) => (
	<Svg {...p}>
		<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z" />
	</Svg>
);

export const MoreIcon = (p) => (
	<Svg {...p}>
		<circle cx="12" cy="12" r="1" />
		<circle cx="19" cy="12" r="1" />
		<circle cx="5" cy="12" r="1" />
	</Svg>
);

export const InfoIcon = (p) => (
	<Svg {...p}>
		<circle cx="12" cy="12" r="10" />
		<path d="M12 16v-4" />
		<path d="M12 8h.01" />
	</Svg>
);

export const BookIcon = (p) => (
	<Svg {...p}>
		<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
	</Svg>
);

export const SearchIcon = (p) => (
	<Svg {...p}>
		<circle cx="11" cy="11" r="8" />
		<path d="m21 21-4.3-4.3" />
	</Svg>
);

export const HeadsetIcon = (p) => (
	<Svg {...p}>
		<path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3" />
	</Svg>
);

export const SparkIcon = (p) => (
	<Svg {...p}>
		<path d="M9.94 15.5A2 2 0 0 0 8.5 14.06l-6.14-1.58a.5.5 0 0 1 0-.96L8.5 9.94A2 2 0 0 0 9.94 8.5l1.58-6.14a.5.5 0 0 1 .96 0L14.06 8.5A2 2 0 0 0 15.5 9.94l6.14 1.58a.5.5 0 0 1 0 .96L15.5 14.06a2 2 0 0 0-1.44 1.44l-1.58 6.14a.5.5 0 0 1-.96 0z" />
	</Svg>
);

export const ArrowRightIcon = (p) => (
	<Svg {...p}>
		<path d="M5 12h14" />
		<path d="m12 5 7 7-7 7" />
	</Svg>
);

export const ArrowLeftIcon = (p) => (
	<Svg {...p}>
		<path d="m12 19-7-7 7-7" />
		<path d="M19 12H5" />
	</Svg>
);

export const ChevronRightIcon = (p) => (
	<Svg {...p}>
		<path d="m9 18 6-6-6-6" />
	</Svg>
);

export const ExternalIcon = (p) => (
	<Svg {...p}>
		<path d="M15 3h6v6" />
		<path d="M10 14 21 3" />
		<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
	</Svg>
);

export const CheckIcon = (p) => (
	<Svg {...p}>
		<path d="M20 6 9 17l-5-5" />
	</Svg>
);

export const XIcon = (p) => (
	<Svg {...p}>
		<path d="M18 6 6 18" />
		<path d="m6 6 12 12" />
	</Svg>
);

export const EyeIcon = (p) => (
	<Svg {...p}>
		<path d="M2.06 12.35a1 1 0 0 1 0-.7 10.75 10.75 0 0 1 19.88 0 1 1 0 0 1 0 .7 10.75 10.75 0 0 1-19.88 0" />
		<circle cx="12" cy="12" r="3" />
	</Svg>
);

export const PlayIcon = (p) => (
	<Svg {...p}>
		<circle cx="12" cy="12" r="10" />
		<path d="m10 8 6 4-6 4Z" />
	</Svg>
);

export const PlugIcon = (p) => (
	<Svg {...p}>
		<path d="M12 22v-5" />
		<path d="M9 8V2" />
		<path d="M15 8V2" />
		<path d="M18 8v5a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4V8Z" />
	</Svg>
);

export const ActivityIcon = (p) => (
	<Svg {...p}>
		<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
	</Svg>
);

export const GaugeIcon = (p) => (
	<Svg {...p}>
		<path d="m12 14 4-4" />
		<path d="M3.34 19a10 10 0 1 1 17.32 0" />
	</Svg>
);

export const CartIcon = (p) => (
	<Svg {...p}>
		<circle cx="8" cy="21" r="1" />
		<circle cx="19" cy="21" r="1" />
		<path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
	</Svg>
);

export const DownloadIcon = (p) => (
	<Svg {...p}>
		<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
		<path d="m7 10 5 5 5-5" />
		<path d="M12 15V3" />
	</Svg>
);

export const LayersIcon = (p) => (
	<Svg {...p}>
		<path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z" />
		<path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65" />
		<path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65" />
	</Svg>
);

export const ServerIcon = (p) => (
	<Svg {...p}>
		<rect width="20" height="8" x="2" y="2" rx="2" />
		<rect width="20" height="8" x="2" y="14" rx="2" />
		<path d="M6 6h.01" />
		<path d="M6 18h.01" />
	</Svg>
);

export const MessageIcon = (p) => (
	<Svg {...p}>
		<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
	</Svg>
);
