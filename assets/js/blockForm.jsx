import React from 'react';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType('unofficial-convertkit/form', {
	title: __('ConvertKit Form'),
	category: 'embed',
	edit() {
		return <div>Hello world</div>;
	},
});
