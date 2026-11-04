/**
 * Small building blocks of the Element Pack-style dashboard: tinted icon
 * tiles, progress bars, cards and pills.
 */

// Soft tile background + icon colour per accent.
export const ACCENTS = {
	blue: { tile: 'bg-[#eef3ff] text-[#2f5bea]', bar: '#2f5bea' },
	navy: { tile: 'bg-[#e8edf8] text-[#00216A]', bar: '#00216A' },
	green: { tile: 'bg-[#ecfdf3] text-[#16a34a]', bar: '#16a34a' },
	violet: { tile: 'bg-[#f3efff] text-[#7c3aed]', bar: '#8b5cf6' },
	amber: { tile: 'bg-[#fff7ed] text-[#d97706]', bar: '#f59e0b' },
	rose: { tile: 'bg-[#fff1f2] text-[#e11d48]', bar: '#e11d48' },
	teal: { tile: 'bg-[#ecfeff] text-[#0e9488]', bar: '#14b8a6' },
	slate: { tile: 'bg-[#f4f4f5] text-[#52525b]', bar: '#71717a' },
};

const TILE_SIZES = {
	sm: 'w-8 h-8 rounded-[9px]',
	md: 'w-[34px] h-[34px] rounded-[10px]',
	lg: 'w-10 h-10 rounded-tile',
	xl: 'w-11 h-11 rounded-tile',
};

export const IconTile = ({ icon: Icon, glyph, accent = 'blue', size = 'lg', iconSize = 18 }) => (
	<span
		className={`grid shrink-0 place-items-center ${TILE_SIZES[size] || TILE_SIZES.lg} ${
			(ACCENTS[accent] || ACCENTS.blue).tile
		}`}
		aria-hidden="true"
	>
		{glyph ? (
			<i className={`${glyph} text-[18px] leading-none`} />
		) : Icon ? (
			<Icon size={iconSize} />
		) : null}
	</span>
);

export const ProgressBar = ({ percent = 0, color = '#2f5bea', height = 6, className = '' }) => (
	<div
		className={`w-full overflow-hidden rounded-full bg-[#eef0f3] ${className}`}
		style={{ height }}
		role="progressbar"
		aria-valuemin={0}
		aria-valuemax={100}
		aria-valuenow={Math.round(percent)}
	>
		<div
			className="h-full rounded-full transition-[width] duration-500"
			style={{ width: `${Math.max(0, Math.min(100, percent))}%`, background: color }}
		/>
	</div>
);

export const Card = ({ title, action, children, className = '', bodyClassName = 'p-[18px]' }) => (
	<section className={`rounded-card border border-solid border-[#e9e9ed] bg-white ${className}`}>
		{title ? (
			<header className="flex items-center justify-between gap-3 px-[18px] pt-[18px]">
				<h2 className="m-0 text-[16px] font-bold tracking-[-.01em] text-[#0f1115]">{title}</h2>
				{action}
			</header>
		) : null}
		<div className={bodyClassName}>{children}</div>
	</section>
);

const PILL_TONES = {
	green: 'text-[#15803d] bg-[#ecfdf3]',
	blue: 'text-[#2f5bea] bg-[#eef3ff]',
	amber: 'text-[#b45309] bg-[#fff7ed]',
	rose: 'text-[#be123c] bg-[#fff1f2]',
	neutral: 'text-[#6d6d74] bg-[#f4f4f5]',
};

export const Pill = ({ tone = 'neutral', children, className = '' }) => (
	<span
		className={`inline-flex items-center whitespace-nowrap rounded-full px-2 py-[3px] text-[11px] font-bold leading-none ${
			PILL_TONES[tone] || PILL_TONES.neutral
		} ${className}`}
	>
		{children}
	</span>
);

export const ProTag = () => (
	<span className="inline-flex items-center rounded-full bg-gradient-brand px-[7px] py-[3px] text-[9.5px] font-extrabold leading-none tracking-[.06em] text-white">
		PRO
	</span>
);
