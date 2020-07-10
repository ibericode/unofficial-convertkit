import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './Edit.jsx';
import save from './Save.jsx';

registerBlockType('unofficial-convertkit/form', {
	title: __('ConvertKit Form'),
	icon: 'dashicons-admin-plugins',
	category: 'embed',
	attributes: {
		selectField: {
			type: 'string',
			default: '24c15b916f',
		},
	},
	edit,
	save,
});
