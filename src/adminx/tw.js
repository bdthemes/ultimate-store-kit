/**
 * Shared Tailwind class strings for adminx (no @apply in SCSS).
 * Specificity scope: tailwind.config.js `important` = `.ultimate-store-kit-admin-root` (PHP wrapper).
 */

export const appShell =
	'flex min-h-[calc(100vh-100px)] flex-col bg-slate-50 m-5 ml-0 font-sans';

/** Row under header: stretch columns to same height so sidebar bg fills to content bottom. */
export const bodyRow = 'flex flex-1 items-stretch p-5 gap-5';

/** Main column grows with page; min-w-0 avoids flex overflow quirks. */
export const mainContent = 'min-w-0 flex-1';

/* Buttons */
const btnBase =
	'inline-flex cursor-pointer items-center gap-1.5 rounded-md border border-transparent px-[18px] py-2 text-[13px] font-semibold leading-snug no-underline transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-60';

export const btnPrimary = `${btnBase} border-uks-brand bg-uks-brand text-white hover:bg-uks-brand-dark`;

export const btnSecondary = `${btnBase} border-slate-300 bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-800`;

export const btnLg = `${btnBase} px-6 py-2.5 text-sm`;

export const btnSm = `${btnBase} px-3 py-1 text-xs`;

export const btnOutlineGreen = `${btnBase} border-uks-brand bg-transparent text-uks-brand hover:bg-uks-brand hover:text-white`;

export const btnOutlineRed = `${btnBase} border-red-500 bg-transparent text-red-500 hover:bg-red-500 hover:text-white`;

export const btnEp = `${btnBase} border-indigo-500 bg-indigo-500 text-white hover:opacity-90`;
export const btnPs = `${btnBase} border-pink-500 bg-pink-500 text-white hover:opacity-90`;
export const btnUpk = `${btnBase} border-orange-500 bg-orange-500 text-white hover:opacity-90`;
export const btnPg = `${btnBase} border-violet-500 bg-violet-500 text-white hover:opacity-90`;
export const btnZb = `${btnBase} border-teal-500 bg-teal-500 text-white hover:opacity-90`;

/* Form */
export const selectLabel = 'whitespace-nowrap text-xs font-semibold text-slate-600';

export const selectInput =
	'min-w-[140px] cursor-pointer rounded-md border border-slate-200 bg-white px-3 py-1.5 text-[13px] text-slate-700 transition-all duration-200 hover:border-slate-300 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-emerald-500';

export const fieldRow =
	'flex items-center justify-between border-b border-slate-100 py-2.5 last:border-b-0';

export const fieldLabel = 'flex items-center gap-2 text-[13px] font-medium text-slate-700';

export const fieldControl =
	'min-w-[120px] rounded-md border border-slate-200 bg-white px-3 py-1.5 text-[13px] text-slate-700 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-emerald-500 disabled:cursor-not-allowed disabled:opacity-50';

export const licenseInput =
	'w-full rounded-md border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 transition-all duration-200 placeholder:text-slate-400 focus:border-uks-brand focus:outline-none focus:ring-2 focus:ring-emerald-500';

/* Toggle — input uses peer; track + knob are siblings after input */
export const toggleLabel = 'relative inline-block h-[22px] w-10 cursor-pointer';

export const toggleInput = 'peer sr-only';

export const toggleTrack =
	'pointer-events-none absolute inset-0 rounded-full bg-slate-300 transition-colors peer-checked:bg-uks-brand peer-disabled:opacity-50';

export const toggleKnob =
	'pointer-events-none absolute bottom-[3px] left-[3px] z-[1] h-4 w-4 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-[18px]';

/* Pro badge on cards */
export const proBadge =
	'shrink-0 whitespace-nowrap rounded-[10px] bg-gradient-to-br from-amber-500 to-orange-500 px-2 py-0.5 text-[10px] font-bold text-white';
