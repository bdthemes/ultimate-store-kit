/**
 * Smooth Toggle switch component.
 * Uses inline styles exclusively so WordPress admin CSS cannot
 * override transform/transition via stylesheet specificity.
 */
const BRAND = '#e20a1d';
const OFF_BG = '#cbd5e1';

// Spring-like easing: fast start, gentle settle
const EASE = 'cubic-bezier(0.34, 1.56, 0.64, 1)';
const EASE_BG = 'cubic-bezier(0.4, 0, 0.2, 1)';

const Toggle = ({ checked, onChange, disabled }) => {
	const trackStyle = {
		position: 'absolute',
		inset: 0,
		borderRadius: '9999px',
		background: checked ? BRAND : OFF_BG,
		transition: `background 0.25s ${EASE_BG}`,
		opacity: disabled ? 0.45 : 1,
		pointerEvents: 'none',
		willChange: 'background',
	};

	const knobStyle = {
		position: 'absolute',
		top: '50%',
		left: 3,
		width: 16,
		height: 16,
		borderRadius: '9999px',
		background: '#fff',
		boxShadow: '0 1px 4px rgba(0,0,0,0.25)',
		transform: checked
			? 'translate(18px, -50%)'
			: 'translate(0px, -50%)',
		transition: `transform 0.3s ${EASE}, box-shadow 0.2s ease`,
		pointerEvents: 'none',
		zIndex: 1,
		willChange: 'transform',
	};

	return (
		<label
			style={{
				position: 'relative',
				display: 'inline-flex',
				alignItems: 'center',
				width: 40,
				height: 22,
				cursor: disabled ? 'not-allowed' : 'pointer',
				flexShrink: 0,
				userSelect: 'none',
			}}
		>
			<input
				type="checkbox"
				checked={checked}
				disabled={disabled}
				onChange={onChange}
				style={{
					position: 'absolute',
					opacity: 0,
					width: 0,
					height: 0,
					margin: 0,
					padding: 0,
					pointerEvents: 'none',
				}}
			/>
			<span style={trackStyle} />
			<span style={knobStyle} />
		</label>
	);
};

export default Toggle;
