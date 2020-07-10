import { hot } from 'react-hot-loader/root';
import React, { useEffect } from 'react';
import ConvertKitForm from 'convertkit-react';
import { InspectorControls } from '@wordpress/editor';
import { SelectControl } from '@wordpress/components';

const Edit = ({ attributes, setAttributes }) => {
	const { selectField } = attributes;
	//Todo: make the parameter configurable

	const onChangeSelectField = (value) =>
		setAttributes({ selectField: value });

	// useEffect(() => {
	// 	const div = document.getElementById('unofficial-convertkit-form');
	// 	const script = document.createElement('script');
	// 	script.async = true;
	// 	script.setAttribute('data-uid', 'f7f67634cc');
	// 	script.src = 'https://deft-thinker-8999.ck.page/f7f67634cc/index.js';
	// 	div.appendChild(script);
	//
	// 	return () => {
	// 		if (document.body.contains(script)) {
	// 			document.body.removeChild(script);
	// 		}
	//
	// 		console.log(script.parentElement);
	// 		div.innerHTML = '';
	// 	};
	// });

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
			<div>Test</div>
		</>
	);
};

export default hot(Edit);
