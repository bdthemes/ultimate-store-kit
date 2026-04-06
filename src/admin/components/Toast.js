import { createPortal } from '@wordpress/element';

/**
 * Fixed top-center toast notification.
 *
 * @param {{ notification: { type: string, message: string } | null, onDismiss: () => void }} props
 */
const Toast = ({ notification, onDismiss }) => {
	if (!notification) return null;

	const typeClass =
		notification.type === 'success' ? 'usk-toast--success' : 'usk-toast--error';

	return createPortal(
		<div className="usk-toast-wrap">
			<div className={`usk-toast ${typeClass}`}>
				<span>{notification.message}</span>
				<button
					type="button"
					className="usk-toast__close"
					onClick={onDismiss}
				>
					&times;
				</button>
			</div>
		</div>,
		document.body
	);
};

export default Toast;
