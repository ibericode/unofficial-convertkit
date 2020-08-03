import 'react-hot-loader';
import { registerBlockType } from '@wordpress/blocks';
import edit from './Edit.jsx';

registerBlockType('unofficial-convertkit/form', {
	title: 'ConvertKit Form',
	icon: 'admin-plugins',
	category: 'embed',
	attributes: {
		formId: {
			type: 'int',
			default: 0,
		},
	},
	edit,
});
