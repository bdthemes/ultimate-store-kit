/**
 * All modules on one page (they used to be a long sidebar list), laid out like
 * Element Pack's Extensions grid. Each card opens the module's own page,
 * where it is switched on and configured.
 */
import { useState, useMemo } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';
import Icon from '../components/Icon';
import { SearchIcon, ChevronRightIcon } from '../components/ui/Icons';
import { Pill, ProTag } from '../components/ui/Primitives';
import { getModuleInfo } from '../utils';

const ModulesPage = ({ items, settings, isPro, onNavigate }) => {
	const [query, setQuery] = useState('');
	const [filter, setFilter] = useState('all');

	const modules = useMemo(
		() => items.map((item) => ({ ...item, ...getModuleInfo(item, settings) })),
		[items, settings]
	);

	const counts = useMemo(
		() => ({
			all: modules.length,
			active: modules.filter((m) => m.status === 'on').length,
			off: modules.filter((m) => m.status !== 'on').length,
		}),
		[modules]
	);

	const visible = modules.filter((m) => {
		if (filter === 'active' && m.status !== 'on') return false;
		if (filter === 'off' && m.status === 'on') return false;
		const q = query.trim().toLowerCase();
		return !q || `${m.label} ${m.description}`.toLowerCase().includes(q);
	});

	const chips = [
		{ key: 'all', label: __('All', 'ultimate-store-kit') },
		{ key: 'active', label: __('Active', 'ultimate-store-kit') },
		{ key: 'off', label: __('Off', 'ultimate-store-kit') },
	];

	return (
		<div>
			<div className="mb-[18px] flex flex-wrap items-end justify-between gap-3">
				<div>
					<h1 className="m-0 text-[26px] font-extrabold tracking-[-.02em] text-[#0f1115]">
						{__('Modules', 'ultimate-store-kit')}
					</h1>
					<p className="m-0 mt-1.5 text-[13.5px] text-[#6c6c75]">
						{sprintf(
							/* translators: 1: active modules, 2: all modules. */
							__('%1$d of %2$d active - store features that work across your whole shop.', 'ultimate-store-kit'),
							counts.active,
							counts.all
						)}
					</p>
				</div>
				<span className="inline-flex items-center gap-[7px] rounded-full border border-solid border-[#c6f0d4] bg-[#ecfdf3] px-3 py-[7px] text-[12.5px] font-bold text-[#15803d]">
					<span className="h-2 w-2 rounded-full bg-[#22c55e]" />
					{sprintf(
						/* translators: %d: number of active modules. */
						__('%d active', 'ultimate-store-kit'),
						counts.active
					)}
				</span>
			</div>

			<div className="mb-[14px] flex flex-wrap items-center justify-between gap-3 rounded-card border border-solid border-[#e9e9ed] bg-white px-[14px] py-3">
				<label className="relative flex w-full max-w-[320px] items-center">
					<span className="sr-only">{__('Search modules', 'ultimate-store-kit')}</span>
					<span className="pointer-events-none absolute left-3 text-[#8a8a93]">
						<SearchIcon size={15} />
					</span>
					<input
						type="search"
						value={query}
						onChange={(event) => setQuery(event.target.value)}
						placeholder={__('Search modules…', 'ultimate-store-kit')}
						className="!m-0 box-border w-full !rounded-full !border !border-solid !border-[#e6e6ea] !bg-[#fafbfc] !py-2 !pl-9 !pr-3 text-[13.5px] !shadow-none focus:!border-[#e30c1d]"
					/>
				</label>
				<div className="flex items-center gap-1 rounded-full bg-[#f4f5f7] p-1" role="group" aria-label={__('Filter modules', 'ultimate-store-kit')}>
					{chips.map((chip) => (
						<button
							key={chip.key}
							type="button"
							onClick={() => setFilter(chip.key)}
							aria-pressed={filter === chip.key}
							className={`cursor-pointer rounded-full border-0 px-3 py-1.5 text-[12.5px] font-bold transition-colors ${
								filter === chip.key ? 'bg-gradient-brand text-white shadow-glow' : 'bg-transparent text-[#52525b] hover:text-[#18181b]'
							}`}
						>
							{chip.label} <span className={filter === chip.key ? 'opacity-80' : 'text-[#8a8a93]'}>{counts[chip.key]}</span>
						</button>
					))}
				</div>
			</div>

			{visible.length === 0 ? (
				<div className="rounded-card border border-solid border-[#e9e9ed] bg-white px-6 py-14 text-center text-[13.5px] text-[#6c6c75]">
					{__('No modules match your search.', 'ultimate-store-kit')}
				</div>
			) : (
				<div className="grid grid-cols-3 gap-[14px] max-[1180px]:grid-cols-2 max-[700px]:grid-cols-1">
					{visible.map((module) => {
						const locked = module.proPlaceholder && !isPro;
						return (
							<button
								key={module.id}
								type="button"
								onClick={() => onNavigate(module.id)}
								className="group flex cursor-pointer flex-col gap-3 rounded-card border border-solid border-[#e9e9ed] bg-white p-[18px] text-left transition-all duration-200 hover:-translate-y-[2px] hover:border-[#fbc8cd] hover:shadow-lift"
							>
								<span className="flex w-full items-start justify-between gap-3">
									<span className="grid h-11 w-11 shrink-0 place-items-center rounded-tile bg-[#fff1f2] text-[#e30c1d] [&_svg]:h-5 [&_svg]:w-5" aria-hidden="true">
										<Icon name={module.icon} />
									</span>
									<span className="flex items-center gap-1.5">
										{locked || module.badge === 'Pro' ? <ProTag /> : null}
										{module.status === 'on' ? (
											<Pill tone="green">{__('Active', 'ultimate-store-kit')}</Pill>
										) : module.status === 'off' ? (
											<Pill>{__('Off', 'ultimate-store-kit')}</Pill>
										) : null}
									</span>
								</span>
								<span className="block">
									<span className="block text-[15px] font-bold text-[#0f1115]">{module.label}</span>
									{module.description ? (
										<span className="mt-1 line-clamp-2 block text-[12.5px] leading-relaxed text-[#6c6c75]">{module.description}</span>
									) : null}
								</span>
								<span className="mt-auto flex items-center gap-1 text-[12.5px] font-bold text-[#e30c1d]">
									{locked ? __('See what it does', 'ultimate-store-kit') : __('Configure', 'ultimate-store-kit')}
									<span className="transition-transform group-hover:translate-x-0.5">
										<ChevronRightIcon size={14} />
									</span>
								</span>
							</button>
						);
					})}
				</div>
			)}
		</div>
	);
};

export default ModulesPage;
