import { hot } from 'react-hot-loader/root';
import React from 'react';
import ConvertKitForm from 'convertkit-react';
import { InspectorControls } from '@wordpress/editor';
import { CheckboxControl } from '@wordpress/components';

const Edit = () => {
	//Todo: make the parameter configurable
	return (
		<>
			<InspectorControls>
				<CheckboxControl
					heading="Checkbox Field"
					label="Tick Me"
					help="Additional help text"
				/>
			</InspectorControls>
			<ConvertKitForm formId={1441335} template="charlotte" />
			<div>Helklo world</div>
		</>
	);
};

export default hot(Edit);
