import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const adminData = window.ultimateStoreKitAdminData || {};

const getRestHeaders = () => ({
	'Content-Type': 'application/json',
	'X-WP-Nonce': adminData.restNonce,
});

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
		<div className="usk-license">
			<div className="usk-license__card">
				<h2 className="usk-license__title">
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
						className={`usk-license__message usk-license__message--${message.type}`}
					>
						<span>{message.text}</span>
						<button
							onClick={() => setMessage(null)}
							className="usk-license__message-close"
						>
							&times;
						</button>
					</div>
				)}

				{isActivated ? (
					<div className="usk-license__activated">
						<ul className="usk-license__info-list">
							<li className="usk-license__info-item">
								<span className="usk-license__info-label">
									{__('Status', 'ultimate-store-kit')}
								</span>
								<span
									className={`usk-license__info-badge ${licenseData.is_valid ? 'usk-license__info-badge--valid' : 'usk-license__info-badge--invalid'}`}
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
								<li className="usk-license__info-item">
									<span className="usk-license__info-label">
										{__(
											'License Type',
											'ultimate-store-kit'
										)}
									</span>
									<span className="usk-license__info-value">
										{licenseData.license_title}
									</span>
								</li>
							)}

							{licenseData.expire_date && (
								<li className="usk-license__info-item">
									<span className="usk-license__info-label">
										{__(
											'License Expires',
											'ultimate-store-kit'
										)}
									</span>
									<span className="usk-license__info-value">
										{licenseData.expire_date}
										{licenseData.expire_renew_link && (
											<a
												href={
													licenseData.expire_renew_link
												}
												target="_blank"
												rel="noopener noreferrer"
												className="usk-license__renew-link"
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
								<li className="usk-license__info-item">
									<span className="usk-license__info-label">
										{__(
											'Support Expires',
											'ultimate-store-kit'
										)}
									</span>
									<span className="usk-license__info-value">
										{licenseData.support_end}
										{licenseData.support_renew_link && (
											<a
												href={
													licenseData.support_renew_link
												}
												target="_blank"
												rel="noopener noreferrer"
												className="usk-license__renew-link"
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
								<li className="usk-license__info-item">
									<span className="usk-license__info-label">
										{__(
											'License Key',
											'ultimate-store-kit'
										)}
									</span>
									<span className="usk-license__info-value usk-license__info-value--mono">
										{licenseData.masked_key}
									</span>
								</li>
							)}
						</ul>

						<div className="usk-license__actions">
							<button
								onClick={handleDeactivate}
								disabled={loading}
								className="usk-btn usk-btn--outline-red"
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
					<div className="usk-license__form-wrap">
						<p className="usk-license__form-desc">
							{__(
								'Enter your license key and registered email to unlock Pro features and receive automatic updates.',
								'ultimate-store-kit'
							)}
						</p>

						<ol className="usk-license__steps">
							<li>
								{__(
									'Log in to your BdThemes account to get your license key.',
									'ultimate-store-kit'
								)}{' '}
								<a
									href="https://bdthemes.onfastspring.com/account"
									target="_blank"
									rel="noopener noreferrer"
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
							className="usk-license__form"
						>
							<div className="usk-license__field">
								<label htmlFor="usk-license-key">
									{__(
										'License Key',
										'ultimate-store-kit'
									)}
								</label>
								<input
									type="text"
									id="usk-license-key"
									value={licenseKey}
									onChange={(e) =>
										setLicenseKey(e.target.value)
									}
									placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx"
									required
								/>
							</div>

							<div className="usk-license__field">
								<label htmlFor="usk-license-email">
									{__(
										'Email Address',
										'ultimate-store-kit'
									)}
								</label>
								<input
									type="email"
									id="usk-license-email"
									value={licenseEmail}
									onChange={(e) =>
										setLicenseEmail(e.target.value)
									}
									placeholder="example@email.com"
									required
								/>
							</div>

							<div className="usk-license__actions">
								<button
									type="submit"
									disabled={loading}
									className="usk-btn usk-btn--primary"
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
										className="usk-btn usk-btn--secondary"
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

			<div className="usk-license__footer-info">
				<p>
					{__(
						'Ultimate Store Kit Addon made with love by',
						'ultimate-store-kit'
					)}{' '}
					<a
						target="_blank"
						rel="noopener noreferrer"
						href="https://bdthemes.com"
					>
						BdThemes
					</a>{' '}
					{__('Team.', 'ultimate-store-kit')}
				</p>
				<p>
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
