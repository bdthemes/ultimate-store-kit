import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { btnOutlineRed, btnPrimary, btnSecondary, licenseInput } from '../tw';

const adminData = window.ultimateStoreKitAdminData || {};

const getRestHeaders = () => ({
	'Content-Type': 'application/json',
	'X-WP-Nonce': adminData.restNonce,
});

const msgBar =
	'animate-usk-slide-in mb-5 flex items-center justify-between rounded-lg px-4 py-2.5 text-[13px] font-medium';

const License = ({ isPro, onLicenseStatusChange }) => {
	const initialLicenseData = adminData.licenseData || {};

	const [licenseData, setLicenseData] = useState(initialLicenseData);
	const [licenseKey, setLicenseKey] = useState('');
	const [licenseEmail, setLicenseEmail] = useState(
		initialLicenseData.license_email || ''
	);
	const [loading, setLoading] = useState(false);
	const [message, setMessage] = useState(
		initialLicenseData.show_message
			? {
					type: 'error',
					text: initialLicenseData.license_message || '',
				}
			: null
	);

	const isActivated = licenseData.is_activated || false;

	useEffect(() => {
		if (!adminData.restUrl) {
			return;
		}

		fetch(`${adminData.restUrl}status`, {
			method: 'GET',
			headers: getRestHeaders(),
		})
			.then((res) => res.json())
			.then((response) => {
				if (response.success && response.license_data) {
					setLicenseData(response.license_data);
					setLicenseEmail(response.license_data.license_email || '');
					if (onLicenseStatusChange) {
						onLicenseStatusChange(true);
					}
				} else if (response.error_message) {
					if (onLicenseStatusChange) {
						onLicenseStatusChange(false);
					}
					setMessage({
						type: 'error',
						text: response.error_message,
					});
				}
			})
			.catch(() => {});
	}, []);

	const handleActivate = (e) => {
		e.preventDefault();

		if (!licenseKey || !licenseEmail) {
			setMessage({
				type: 'error',
				text: __(
					'Please provide both license key and email address.',
					'ultimate-store-kit'
				),
			});
			return;
		}

		setLoading(true);
		setMessage(null);

		fetch(`${adminData.restUrl}activate`, {
			method: 'POST',
			headers: getRestHeaders(),
			body: JSON.stringify({
				license_key: licenseKey,
				email: licenseEmail,
			}),
		})
			.then((res) => res.json())
			.then((response) => {
				if (response.success) {
					setLicenseData(response.license_data);
					if (onLicenseStatusChange) {
						onLicenseStatusChange(true);
					}
					setMessage({
						type: 'success',
						text:
							response.message ||
							__(
								'License activated successfully!',
								'ultimate-store-kit'
							),
					});
					setLicenseKey('');
				} else {
					if (onLicenseStatusChange) {
						onLicenseStatusChange(false);
					}
					setMessage({
						type: 'error',
						text:
							response.message ||
							__(
								'License activation failed.',
								'ultimate-store-kit'
							),
					});
				}
			})
			.catch(() => {
				setMessage({
					type: 'error',
					text: __(
						'An error occurred. Please try again.',
						'ultimate-store-kit'
					),
				});
			})
			.finally(() => {
				setLoading(false);
			});
	};

	const handleDeactivate = () => {
		if (
			!window.confirm(
				__(
					'Are you sure you want to deactivate the license?',
					'ultimate-store-kit'
				)
			)
		) {
			return;
		}

		setLoading(true);
		setMessage(null);

		fetch(`${adminData.restUrl}deactivate`, {
			method: 'DELETE',
			headers: getRestHeaders(),
		})
			.then((res) => res.json())
			.then((response) => {
				if (response.success) {
					setLicenseData({});
					if (onLicenseStatusChange) {
						onLicenseStatusChange(false);
					}
					setLicenseEmail('');
					setLicenseKey('');
					setMessage({
						type: 'success',
						text:
							response.message ||
							__(
								'License deactivated successfully.',
								'ultimate-store-kit'
							),
					});
				} else {
					setMessage({
						type: 'error',
						text:
							response.message ||
							__(
								'Failed to deactivate license.',
								'ultimate-store-kit'
							),
					});
				}
			})
			.catch(() => {
				setMessage({
					type: 'error',
					text: __(
						'An error occurred. Please try again.',
						'ultimate-store-kit'
					),
				});
			})
			.finally(() => {
				setLoading(false);
			});
	};

	return (
		<div className="max-w-[640px]">
			<div className="mb-4 rounded-usk border border-slate-200 bg-white p-8">
				<h2 className="mb-5 text-xl font-bold text-slate-800">
					{isActivated
						? __(
								'Ultimate Store Kit License Info',
								'ultimate-store-kit'
							)
						: __(
								'Activate Your License',
								'ultimate-store-kit'
							)}
				</h2>

				{message && (
					<div
						className={`${msgBar} ${
							message.type === 'success'
								? 'border border-emerald-200 bg-emerald-100 text-emerald-800'
								: 'border border-red-200 bg-red-100 text-red-900'
						}`}
					>
						<span>{message.text}</span>
						<button
							type="button"
							onClick={() => setMessage(null)}
							className="cursor-pointer border-0 bg-transparent px-1 text-lg leading-none text-inherit"
						>
							&times;
						</button>
					</div>
				)}

				{isActivated ? (
					<div className="block">
						<ul className="m-0 mb-6 list-none p-0">
							<li className="flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0">
								<span className="font-semibold text-slate-600">
									{__('Status', 'ultimate-store-kit')}
								</span>
								<span
									className={`rounded-[10px] px-3 py-0.5 text-xs font-semibold ${
										licenseData.is_valid
											? 'bg-emerald-100 text-emerald-800'
											: 'bg-red-100 text-red-900'
									}`}
								>
									{licenseData.is_valid
										? __(
												'Valid',
												'ultimate-store-kit'
											)
										: __(
												'Invalid',
												'ultimate-store-kit'
											)}
								</span>
							</li>

							{licenseData.license_title && (
								<li className="flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0">
									<span className="font-semibold text-slate-600">
										{__(
											'License Type',
											'ultimate-store-kit'
										)}
									</span>
									<span className="text-slate-700">
										{licenseData.license_title}
									</span>
								</li>
							)}

							{licenseData.expire_date && (
								<li className="flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0">
									<span className="font-semibold text-slate-600">
										{__(
											'License Expires',
											'ultimate-store-kit'
										)}
									</span>
									<span className="flex items-center gap-2 text-slate-700">
										{licenseData.expire_date}
										{licenseData.expire_renew_link && (
											<a
												href={
													licenseData.expire_renew_link
												}
												target="_blank"
												rel="noopener noreferrer"
												className="rounded border border-uks-brand px-2.5 py-0.5 text-xs font-semibold text-uks-brand no-underline transition-all hover:bg-uks-brand hover:text-white"
											>
												{__(
													'Renew',
													'ultimate-store-kit'
												)}
											</a>
										)}
									</span>
								</li>
							)}

							{licenseData.support_end && (
								<li className="flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0">
									<span className="font-semibold text-slate-600">
										{__(
											'Support Expires',
											'ultimate-store-kit'
										)}
									</span>
									<span className="flex items-center gap-2 text-slate-700">
										{licenseData.support_end}
										{licenseData.support_renew_link && (
											<a
												href={
													licenseData.support_renew_link
												}
												target="_blank"
												rel="noopener noreferrer"
												className="rounded border border-uks-brand px-2.5 py-0.5 text-xs font-semibold text-uks-brand no-underline transition-all hover:bg-uks-brand hover:text-white"
											>
												{__(
													'Renew',
													'ultimate-store-kit'
												)}
											</a>
										)}
									</span>
								</li>
							)}

							{licenseData.masked_key && (
								<li className="flex items-center justify-between border-b border-slate-100 py-3 text-[13px] last:border-b-0">
									<span className="font-semibold text-slate-600">
										{__(
											'License Key',
											'ultimate-store-kit'
										)}
									</span>
									<span className="font-mono text-xs tracking-wide text-slate-500">
										{licenseData.masked_key}
									</span>
								</li>
							)}
						</ul>

						<div className="mt-1 flex gap-2">
							<button
								type="button"
								onClick={handleDeactivate}
								disabled={loading}
								className={btnOutlineRed}
							>
								{loading
									? __(
											'Deactivating...',
											'ultimate-store-kit'
										)
									: __(
											'Deactivate License',
											'ultimate-store-kit'
										)}
							</button>
						</div>
					</div>
				) : (
					<div className="mt-0">
						<p className="mb-4 text-[13px] leading-relaxed text-slate-500">
							{__(
								'Enter your license key and registered email to unlock Pro features and receive automatic updates.',
								'ultimate-store-kit'
							)}
						</p>

						<ol className="mb-6 list-decimal pl-5 text-[13px] leading-loose text-slate-600">
							<li>
								{__(
									'Log in to your BdThemes account to get your license key.',
									'ultimate-store-kit'
								)}{' '}
								<a
									href="https://bdthemes.onfastspring.com/account"
									target="_blank"
									rel="noopener noreferrer"
									className="font-semibold text-uks-brand no-underline hover:underline"
								>
									{__(
										'Go to account',
										'ultimate-store-kit'
									)}
								</a>
							</li>
							<li>
								{__(
									"If you don't yet have a license key,",
									'ultimate-store-kit'
								)}{' '}
								<a
									href="https://storekit.pro/pricing/"
									target="_blank"
									rel="noopener noreferrer"
									className="font-semibold text-uks-brand no-underline hover:underline"
								>
									{__(
										'get Ultimate Store Kit Pro now',
										'ultimate-store-kit'
									)}
								</a>
								.
							</li>
							<li>
								{__(
									'Copy the license key from your account and paste it below.',
									'ultimate-store-kit'
								)}
							</li>
						</ol>

						<form
							onSubmit={handleActivate}
							className="flex flex-col gap-4"
						>
							<div className="flex flex-col gap-1.5">
								<label
									htmlFor="usk-license-key"
									className="text-[13px] font-semibold text-slate-700"
								>
									{__(
										'License Key',
										'ultimate-store-kit'
									)}
								</label>
								<input
									type="text"
									id="usk-license-key"
									className={licenseInput}
									value={licenseKey}
									onChange={(e) =>
										setLicenseKey(e.target.value)
									}
									placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx"
									required
								/>
							</div>

							<div className="flex flex-col gap-1.5">
								<label
									htmlFor="usk-license-email"
									className="text-[13px] font-semibold text-slate-700"
								>
									{__(
										'Email Address',
										'ultimate-store-kit'
									)}
								</label>
								<input
									type="email"
									id="usk-license-email"
									className={licenseInput}
									value={licenseEmail}
									onChange={(e) =>
										setLicenseEmail(e.target.value)
									}
									placeholder="example@email.com"
									required
								/>
							</div>

							<div className="mt-1 flex gap-2">
								<button
									type="submit"
									disabled={loading}
									className={btnPrimary}
								>
									{loading
										? __(
												'Activating...',
												'ultimate-store-kit'
											)
										: __(
												'Activate License',
												'ultimate-store-kit'
											)}
								</button>
								{!isPro && (
									<a
										href="https://storekit.pro/pricing/"
										target="_blank"
										rel="noopener noreferrer"
										className={btnSecondary}
									>
										{__(
											'Get Pro License',
											'ultimate-store-kit'
										)}
									</a>
								)}
							</div>
						</form>
					</div>
				)}
			</div>

			<div className="p-4 text-center">
				<p className="my-0.5 text-xs text-slate-400">
					{__(
						'Ultimate Store Kit Addon made with love by',
						'ultimate-store-kit'
					)}{' '}
					<a
						target="_blank"
						rel="noopener noreferrer"
						href="https://bdthemes.com"
						className="text-uks-brand no-underline"
					>
						BdThemes
					</a>{' '}
					{__('Team.', 'ultimate-store-kit')}
				</p>
				<p className="my-0.5 text-xs text-slate-400">
					{__(
						'All rights reserved by BdThemes.',
						'ultimate-store-kit'
					)}
				</p>
			</div>
		</div>
	);
};

export default License;
