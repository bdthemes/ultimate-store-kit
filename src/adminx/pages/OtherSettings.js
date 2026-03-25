import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import ProPromo from '../components/ProPromo';

const OtherSettings = ({ widgets, section, settings, onSave, saving, isPro }) => {
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

	const groups = renderGroups();

	return (
		<div className="usk-other-settings">
			<div className="usk-other-settings__header">
				<h2 className="usk-other-settings__title">
					{__('Other Settings', 'ultimate-store-kit')}
				</h2>
			</div>

			{groups.map((group, gi) => (
				<div key={gi} className="usk-settings-group">
					<h3 className="usk-settings-group__title">{group.label}</h3>
					<div className="usk-settings-group__body">
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
										className="usk-settings-field"
									>
										<div className="usk-settings-field__label">
											<span>
												{item.label}
												{hasMissingDependency && dependency?.actionUrl ? (
													<>
														{' '}
														<a
															href={dependency.actionUrl}
															target={dependency.actionType === 'install' ? '_blank' : undefined}
															rel={dependency.actionType === 'install' ? 'noopener noreferrer' : undefined}
														>
															{dependency.actionLabel}
														</a>
													</>
												) : null}
											</span>
											{isProItem && (
												<span className="usk-widget-card__badge">
													{__('Pro', 'ultimate-store-kit')}
												</span>
											)}
										</div>
										<label className="usk-toggle">
											<input
												type="checkbox"
												checked={isOn}
												disabled={isDisabled}
												onChange={() =>
													handleChange(
														item.name,
														isOn ? 'off' : 'on'
													)
												}
											/>
											<span className="usk-toggle__slider"></span>
										</label>
										{hasMissingDependency && dependency?.message && (
											<div className="usk-license__form-desc">
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
										className="usk-settings-field"
									>
										<label className="usk-settings-field__label">
											{item.label}
										</label>
										<select
											className="usk-settings-field__select"
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
										className="usk-settings-field"
									>
										<label className="usk-settings-field__label">
											{item.label}
										</label>
										<input
											type={item.type}
											className="usk-settings-field__input"
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

			<div className="usk-widgets-page__footer">
				<button
					className="usk-btn usk-btn--primary usk-btn--lg"
					onClick={handleSave}
					disabled={saving}
				>
					{saving
						? __('Saving...', 'ultimate-store-kit')
						: __('Save Changes', 'ultimate-store-kit')}
				</button>
			</div>

			{!isPro && <ProPromo />}
		</div>
	);
};

export default OtherSettings;
