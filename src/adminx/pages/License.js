import { __ } from '@wordpress/i18n';

const License = ({ isPro }) => {
	return (
		<div className="usk-license">
			<div className="usk-license__card">
				<h2 className="usk-license__title">
					{__('License', 'ultimate-store-kit')}
				</h2>

				{isPro ? (
					<div className="usk-license__active">
						<div className="usk-license__status">
							<span className="dashicons dashicons-yes-alt"></span>
							<span>
								{__(
									'Your license is active.',
									'ultimate-store-kit'
								)}
							</span>
						</div>
						<p>
							{__(
								'Thank you for activating the Pro version. You have access to all premium features and priority support.',
								'ultimate-store-kit'
							)}
						</p>
						<a
							href="https://account.bdthemes.com/"
							target="_blank"
							rel="noopener noreferrer"
							className="usk-btn usk-btn--secondary"
						>
							{__('Manage License', 'ultimate-store-kit')}
						</a>
					</div>
				) : (
					<div className="usk-license__inactive">
						<div className="usk-license__status usk-license__status--inactive">
							<span className="dashicons dashicons-warning"></span>
							<span>
								{__(
									'No active license found.',
									'ultimate-store-kit'
								)}
							</span>
						</div>
						<p>
							{__(
								'To unlock all premium features and get priority support, please purchase and activate a Pro license.',
								'ultimate-store-kit'
							)}
						</p>
						<div className="usk-license__actions">
							<a
								href="https://storekit.pro/pricing/"
								target="_blank"
								rel="noopener noreferrer"
								className="usk-btn usk-btn--primary"
							>
								{__('Get Pro License', 'ultimate-store-kit')}
							</a>
							<a
								href="https://account.bdthemes.com/"
								target="_blank"
								rel="noopener noreferrer"
								className="usk-btn usk-btn--secondary"
							>
								{__(
									'Already have a license?',
									'ultimate-store-kit'
								)}
							</a>
						</div>
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
