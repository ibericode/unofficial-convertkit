import { hot } from 'react-hot-loader/root';
import React from 'react';
import { InspectorControls } from '@wordpress/editor';
import { SelectControl, SandBox } from '@wordpress/components';

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
