import { hot } from 'react-hot-loader/root';
import React from 'react';
import ConvertKitForm from 'convertkit-react';
import { InspectorControls } from '@wordpress/editor';
import { SelectControl } from '@wordpress/components';

const Edit = ({ attributes, setAttributes }) => {
	const { selectField } = attributes;
	//Todo: make the parameter configurable

	const onChangeSelectField = (value) =>
		setAttributes({ selectField: value });

	return (
		<>
			<InspectorControls>
				<SelectControl
					label="Form"
					value={selectField}
					options={[
						{ value: 1441335, label: 'Charlotte form' },
						{ value: 1441318, label: 'Powell form' },
					]}
					onChange={onChangeSelectField}
				/>
				{/*<SelectControl*/}
				{/*	label="Themes"*/}
				{/*	value=""*/}
				{/*/>*/}
			</InspectorControls>
			<ConvertKitForm formId={selectField} template="charlotte" />
		</>
	);
};

export default hot(Edit);
