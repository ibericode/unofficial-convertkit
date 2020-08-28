import { registerBlockType } from '@wordpress/blocks';
import edit from './edit.jsx';

registerBlockType('unofficial-convertkit/form', {
	title: 'ConvertKit Form',
	icon: 'admin-plugins',
	category: 'embed',
	attributes: {
		formId: {
			type: 'int',
			default: 0,
		},
		embedUrl: {
			type: 'string',
			default: null,
		},
		formUid: {
			type: 'string',
			default: null,
		},
	},
	edit,
});
