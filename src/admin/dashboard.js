import { createRoot } from '@wordpress/element';
import App from './App';
import './style.scss';

document.addEventListener('DOMContentLoaded', () => {
	const root = document.querySelector('.ultimate-store-kit-admin-root');
	if (root) {
		createRoot(root).render(<App />);
	}
});