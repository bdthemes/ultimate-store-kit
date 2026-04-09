import { adminIconMap } from '../icons';

const Icon = ({ name }) => {
	const Component = adminIconMap[name] || adminIconMap.info;
	return <Component />;
};

export default Icon;
