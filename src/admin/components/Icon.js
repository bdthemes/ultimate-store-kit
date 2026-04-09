import { applyFilters } from '@wordpress/hooks';
import { adminIconMap } from '../icons';

const Icon = ({ name }) => {
	const iconMap = applyFilters('usk.admin.iconMap', adminIconMap);
	const Component = iconMap[name] || iconMap.info;
	return <Component />;
};

export default Icon;
