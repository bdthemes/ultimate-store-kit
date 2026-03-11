import { __ } from '@wordpress/i18n';

const Header = ({ version }) => {
	return (
		<div className="usk-admin-header">
			<div className="usk-admin-header__left">
				<div className="usk-admin-header__logo">
					<svg
						width="32"
						height="32"
						viewBox="0 0 1010 1024"
						fill="none"
						xmlns="http://www.w3.org/2000/svg"
					>
						<path
							fill="#ffffff"
							d="M911.638 879.878l-51.416-503.357c-5.935-56.843-53.595-100.775-111.514-100.775-0.111 0-0.222 0-0.332 0h-472.748c-0.161 0-0.352-0.002-0.545-0.002-58.369 0-106.292 44.717-111.382 101.761l-0.031 0.429-46.017 503.357c-0.293 3.043-0.46 6.58-0.46 10.154 0 62.098 50.324 112.441 112.413 112.472h570.201c62.106-0.108 112.411-50.478 112.411-112.6 0-4.029-0.212-8.008-0.625-11.928l0.042 0.49z"
						/>
						<path
							fill="#1e293b"
							d="M229.611 905.585c-0.014 0-0.033 0-0.050 0-7.454 0-13.496-6.043-13.496-13.496 0-0.408 0.017-0.811 0.054-1.208l-0.003 0.052 46.017-503.357c0-7.099 5.755-12.854 12.854-12.854v0h472.894c6.965 0.021 12.697 5.265 13.491 12.019l0.007 0.064 21.594 209.389c-73.984 3.594-140.814 31.559-193.28 75.97l0.472-0.391c-80.208 68.639-113.114 167.101-126.482 233.298z"
						/>
						<path
							fill="#1e293b"
							d="M799.808 905.585h-231.369c12.854-48.973 37.661-112.343 88.435-155.532 36.734-30.62 83.98-49.763 135.643-51.407l0.351-0.009 19.666 191.393c0.106 0.618 0.165 1.33 0.165 2.057 0 7.099-5.755 12.854-12.854 12.854-0.014 0-0.026 0-0.040 0h0.002z"
						/>
					</svg>
				</div>
				<div className="usk-admin-header__info">
					<h1 className="usk-admin-header__title">
						{__('Ultimate Store Kit', 'ultimate-store-kit')}
					</h1>
					{version && (
						<span className="usk-admin-header__version">
							v{version}
						</span>
					)}
				</div>
			</div>
			<div className="usk-admin-header__right">
				<a
					href="https://storekit.pro/pricing/"
					target="_blank"
					rel="noopener noreferrer"
					className="usk-admin-header__btn"
				>
					{__('Get Pro', 'ultimate-store-kit')}
				</a>
				<a
					href="https://bdthemes.com/support/"
					target="_blank"
					rel="noopener noreferrer"
					className="usk-admin-header__btn usk-admin-header__btn--outline"
				>
					{__('Support', 'ultimate-store-kit')}
				</a>
			</div>
		</div>
	);
};

export default Header;
