import { hot } from 'react-hot-loader/root';
import React, { useEffect } from 'react';
import { InspectorControls } from '@wordpress/editor';
import { SelectControl, SandBox } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';

import { renderToString } from '@wordpress/element';

const ScriptTag = (uuid) => (
	<script
		async
		data-uid={uuid}
		src={`https://deft-thinker-8999.ck.page/${uuid}/index.js`}
	/>
);

const Edit = ({ attributes, setAttributes }) => {
	const { selectField } = attributes;

	useEffect(() => {
		apiFetch({ path: 'unofficial-convertkit/v1/forms' }).then((data) =>
			console.log(data)
		);
	});

	//Todo: make the parameter configurable
	const onChangeSelectField = (value) => {
		setAttributes({ selectField: value });
	};

	return (
		<>
			<InspectorControls>
				<SelectControl
					label="Form"
					value={selectField}
					options={[
						{ value: '24c15b916f', label: 'Charlotte form' },
						{ value: 'f7f67634cc', label: 'Powell form' },
					]}
					onChange={onChangeSelectField}
				/>
			</InspectorControls>
			<SandBox
				key={selectField}
				html={renderToString(ScriptTag(selectField))}
			/>
		</>
	);
};

export default hot(Edit);
