import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './Edit.jsx';
import save from './Save.js';
import icon from './BlockIcon.jsx';

registerBlockType('unofficial-convertkit/form', {
	title: __('ConvertKit Form'),
	icon,
	category: 'embed',
	attributes: {
		formUid: {
			type: 'string',
			default: '',
		},
	},
	edit,
	save,
});
