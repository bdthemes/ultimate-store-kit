import { __ } from '@wordpress/i18n';

const WelcomeStatCard = ({ title, data, color }) => {
	const percentage =
		data.total > 0 ? Math.round((data.active / data.total) * 100) : 0;

	return (
		<div className="rounded-lg border border-solid border-gray-100 bg-white p-4">
			<h3 className="m-0 mb-3 text-[13px] font-semibold uppercase tracking-wide text-slate-500">
				{title}
			</h3>
			<div className="flex items-center justify-between gap-3">
				<div className="flex flex-col gap-1">
					<div className="flex gap-1.5 text-[13px] text-slate-700">
						<span className="text-slate-400">
							{__('Active:', 'ultimate-store-kit')}
						</span>
						<strong>{data.active}</strong>
					</div>
					<div className="flex gap-1.5 text-[13px] text-slate-700">
						<span className="text-slate-400">
							{__('Inactive:', 'ultimate-store-kit')}
						</span>
						<strong>{data.inactive}</strong>
					</div>
					<div className="flex gap-1.5 text-[13px] text-slate-700">
						<span className="text-slate-400">
							{__('Total:', 'ultimate-store-kit')}
						</span>
						<strong>{data.total}</strong>
					</div>
				</div>
				<div className="h-[60px] w-[60px] shrink-0">
					<svg viewBox="0 0 36 36" className="h-full w-full">
						<path
							d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
							fill="none"
							stroke="#e2e8f0"
							strokeWidth="3"
						/>
						<path
							d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
							fill="none"
							stroke={color}
							strokeWidth="3"
							strokeDasharray={`${percentage}, 100`}
						/>
						<text
							x="18"
							y="20.5"
							className="font-bold"
							textAnchor="middle"
							fontSize="8"
							fill="#334155"
						>
							{percentage}%
						</text>
					</svg>
				</div>
			</div>
		</div>
	);
};

export default WelcomeStatCard;
