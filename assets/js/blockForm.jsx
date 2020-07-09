import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './Edit.jsx';

registerBlockType('unofficial-convertkit/form', {
	title: __('ConvertKit Form'),
	icon: 'dashicons-admin-plugins',
	category: 'embed',
	edit,
});
