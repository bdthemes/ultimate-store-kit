import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import ProPromo from '../components/ProPromo';
import { btnLg, btnPrimary, fieldControl, fieldLabel, proBadge, Toggle } from '../tw';

const OtherSettings = ({ widgets, section, settings, onSave, saving, isPro, activeGroup }) => {
	const [localSettings, setLocalSettings] = useState(() => {
		const initial = {};
		widgets.forEach((w) => {
			if (w.type === 'start_group' || w.type === 'end_group') return;
			if (w.type === 'checkbox') {
				initial[w.name] =
					settings[w.name] !== undefined
						? settings[w.name]
						: w.default || 'off';
			} else if (w.type === 'select' || w.type === 'number' || w.type === 'text') {
				initial[w.name] =
					settings[w.name] !== undefined
						? settings[w.name]
						: w.default || '';
			}
		});
		return initial;
	});

	const handleChange = (name, value) => {
		setLocalSettings((prev) => ({ ...prev, [name]: value }));
	};

	const handleSave = () => {
		onSave(section, localSettings);
	};

	const renderGroups = () => {
		const groups = [];
		let currentGroup = null;

		widgets.forEach((w) => {
			if (w.type === 'start_group') {
				currentGroup = { label: w.label, items: [] };
				return;
			}
			if (w.type === 'end_group') {
				if (currentGroup) {
					groups.push(currentGroup);
					currentGroup = null;
				}
				return;
			}
			if (currentGroup) {
				currentGroup.items.push(w);
			} else {
				if (!groups.length || groups[groups.length - 1].items === undefined) {
					groups.push({ label: __('General', 'ultimate-store-kit'), items: [] });
				}
				groups[groups.length - 1].items.push(w);
			}
		});

		return groups;
	};

	const allGroups = renderGroups();
	const groups = activeGroup
		? allGroups.filter((g) => g.label === activeGroup)
		: allGroups;

	return (
		<div>
			{/* Auto columns: container যত জায়গা দিবে, ততটা সমান-width কলামে সাজাবে */}
			<div className="grid grid-cols-[repeat(auto-fit,minmax(420px,1fr))] items-start gap-4">
				{groups.map((group, gi) => (
					<div
						key={gi}
						className="w-full overflow-hidden rounded-usk border border-solid border-gray-100 bg-white"
					>
						<h3 className="m-0 border-0 border-b border-solid border-b-gray-200  px-5 py-3.5 text-sm font-bold uppercase tracking-wide text-slate-700">
							{group.label}
						</h3>
						<div className="space-y-5 p-5">
							{group.items.map((item) => {
								const isProItem = item.widget_type === 'pro';
								const dependency = item.dependency || null;
								const hasMissingDependency =
									dependency && (!dependency.isInstalled || !dependency.isActive);
								const isDisabled = (isProItem && !isPro) || hasMissingDependency;

								if (item.type === 'checkbox') {
									const isOn =
										!isDisabled &&
										localSettings[item.name] === 'on';
									return (
										<div
											key={item.name}
											className="rounded-lg border border-slate-200 bg-white"
										>
											<div className="flex items-center justify-between gap-3">
												<div className={`${fieldLabel} max-w-[70%] flex-wrap`}>
													<span>
														{item.label}
														{hasMissingDependency && dependency?.actionUrl ? (
															<>
																{' '}
																<a
																	href={dependency.actionUrl}
																	target={dependency.actionType === 'install' ? '_blank' : undefined}
																	rel={dependency.actionType === 'install' ? 'noopener noreferrer' : undefined}
																	className="font-semibold text-uks-brand hover:underline"
																>
																	{dependency.actionLabel}
																</a>
															</>
														) : null}
													</span>
													{isProItem && (
														<span className={proBadge}>
															{__('Pro', 'ultimate-store-kit')}
														</span>
													)}
												</div>
												<Toggle
												checked={isOn}
												disabled={isDisabled}
												onChange={() =>
													handleChange(
														item.name,
														isOn ? 'off' : 'on'
													)
												}
											/>
											</div>
											{hasMissingDependency && dependency?.message && (
												<div className="mt-2 text-[13px] leading-relaxed text-slate-500">
													{dependency.message}
												</div>
											)}
										</div>
									);
								}

								if (item.type === 'select') {
									return (
										<div
											key={item.name}
											className="rounded-lg border border-slate-200 bg-white"
										>
											<label className={fieldLabel}>
												{item.label}
												{isProItem && (
													<span className={`${proBadge} ml-2 align-middle`}>
														{__('Pro', 'ultimate-store-kit')}
													</span>
												)}
											</label>
											<select
												className={`${fieldControl} mt-2 block w-full`}
												value={
													localSettings[item.name] || ''
												}
												onChange={(e) =>
													handleChange(
														item.name,
														e.target.value
													)
												}
												disabled={isDisabled}
											>
												{item.options &&
													Object.entries(
														item.options
													).map(([val, lbl]) => (
														<option
															key={val}
															value={val}
														>
															{lbl}
														</option>
													))}
											</select>
										</div>
									);
								}

								if (
									item.type === 'number' ||
									item.type === 'text'
								) {
									return (
										<div
											key={item.name}
											className="rounded-lg border border-slate-200 bg-white"
										>
											<label className={fieldLabel}>
												{item.label}
												{isProItem && (
													<span className={`${proBadge} ml-2 align-middle`}>
														{__('Pro', 'ultimate-store-kit')}
													</span>
												)}
											</label>
											<input
												type={item.type}
												className={`${fieldControl} mt-2 block w-full`}
												value={
													localSettings[item.name] || ''
												}
												onChange={(e) =>
													handleChange(
														item.name,
														e.target.value
													)
												}
												disabled={isDisabled}
											/>
										</div>
									);
								}

								return null;
							})}
						</div>
					</div>
				))}
				{!isPro && !activeGroup && <ProPromo />}
			</div>
			<div className="mt-6 flex justify-end pt-4">
				<button
					type="button"
					className={`${btnLg} ${btnPrimary}`}
					onClick={handleSave}
					disabled={saving}
				>
					{saving
						? __('Saving...', 'ultimate-store-kit')
						: __('Save Changes', 'ultimate-store-kit')}
				</button>
			</div>
		</div>
	);
};

export default OtherSettings;
