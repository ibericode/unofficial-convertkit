import 'react-hot-loader';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './Edit.jsx';

registerBlockType('unofficial-convertkit/form', {
	title: __('ConvertKit Form'),
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
