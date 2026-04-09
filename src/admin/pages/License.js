import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { CheckIcon, CloseIcon } from '../icons';
import { btnPrimary, btnSecondary, licenseInput } from '../tw';

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

		fetch(`${adminData.restUrl}license/status`, {
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

		fetch(`${adminData.restUrl}license/activate`, {
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

		fetch(`${adminData.restUrl}license/deactivate`, {
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
		<div className="">
			<div className="mb-4 rounded-lg border border-solid border-gray-100 bg-white p-8">
				<div className="mb-6 border-0 border-b border-solid border-b-gray-100 pb-4">
					<h2 className="m-0 mb-1 text-xl font-bold text-slate-800">
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
					<p className="m-0 text-[14px] leading-relaxed text-slate-500">
						{isActivated
							? __(
									'Your license is active. View details and manage your subscription below.',
									'ultimate-store-kit'
								)
							: __(
									'Enter your license key to activate and receive updates & premium support.',
									'ultimate-store-kit'
								)}
					</p>
				</div>

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
						<div className="mb-5">
								<div className="flex flex-col gap-4">
								   <div className="flex flex-col gap-2 border-0 border-b border-solid border-b-gray-100 pb-4">
										<span className="text-[14px] font-semibold text-slate-600">
										{__('Status', 'ultimate-store-kit')}
									</span>
									<span
										className={`inline-flex items-center gap-2 self-start rounded-[10px] px-3 py-1 text-xs font-bold ${
											licenseData.is_valid
													? 'border border-emerald-200 bg-emerald-100 text-emerald-800'
													: 'border border-red-200 bg-red-100 text-red-900'
										}`}
									>
										{licenseData.is_valid ? (
											<CheckIcon className="h-[14px] w-[14px]" />
										) : (
											<CloseIcon className="h-[14px] w-[14px]" />
										)}
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
								</div>

								{licenseData.license_title && (
									<div className="flex flex-col gap-1 border-0 border-b border-solid border-b-gray-100 pb-4">
										<span className="text-[14px] font-semibold text-slate-600">
											{__(
												'License Type',
												'ultimate-store-kit'
											)}
										</span>
										<span className="text-[14px] text-slate-800">
											{licenseData.license_title}
										</span>
									</div>
								)}

								{licenseData.expire_date && (
									<div className="flex flex-col gap-1 border-0 border-b border-solid border-b-gray-100 pb-4">
										<span className="text-[14px] font-semibold text-slate-600">
											{__(
												'License Expired on',
												'ultimate-store-kit'
											)}
										</span>
										<span className="text-[14px] text-slate-800">
											{licenseData.expire_date}
										</span>
									</div>
								)}

								{licenseData.support_end && (
									<div className="flex flex-col gap-1 border-0 border-b border-solid border-b-gray-100 pb-4">
										<span className="text-[14px] font-semibold text-slate-600">
											{__(
												'Support Expired on',
												'ultimate-store-kit'
											)}
										</span>
										<span className="text-[14px] text-slate-800">
											{licenseData.support_end}
										</span>
									</div>
								)}

								{licenseData.masked_key && (
									<div className="flex flex-col gap-2  pb-4">
										<span className="text-[14px] font-semibold text-slate-600">
											{__(
												'Your License Key',
												'ultimate-store-kit'
											)}
										</span>
										<span className="inline-flex w-fit max-w-full items-center rounded-md border border-slate-200 bg-slate-50 px-3 py-2 font-mono text-[12px] text-slate-700">
											{licenseData.masked_key}
										</span>
									</div>
								)}
							</div>

							<button
								type="button"
								onClick={handleDeactivate}
								disabled={loading}
								className="mt-4 inline-flex items-center justify-center rounded-md border border-solid border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 cursor-pointer  transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-60"
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
						<form onSubmit={handleActivate} className="flex flex-col gap-5">
							<div className="flex flex-col gap-1.5">
								<label
									htmlFor="usk-license-key"
									className="text-[13px] font-semibold text-slate-700"
								>
									{__('License Code', 'ultimate-store-kit')}
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
									{__('Email Address', 'ultimate-store-kit')}
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

							<p className="m-0 text-[12px] leading-relaxed text-slate-500">
								{__(
									'We will send update news of this product by this email address, don\'t worry, we hate spam.',
									'ultimate-store-kit'
								)}
							</p>

							<div className="mt-1 flex items-center gap-3">
								<button
									type="submit"
									disabled={loading}
									className={`${btnPrimary} rounded-md inline-flex items-center justify-center`}
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
		</div>
	);
};

export default License;
