import { hot } from 'react-hot-loader/root';
import React, { useEffect } from 'react';
import { InspectorControls } from '@wordpress/editor';
import { SelectControl, SandBox, Spinner } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';
import { renderToString, useState } from '@wordpress/element';
import { dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

const { createErrorNotice } = dispatch('core/notices');

const ScriptTag = (uuid) => (
	<script
		async
		data-uid={uuid}
		src={`https://deft-thinker-8999.ck.page/${uuid}/index.js`}
	/>
);

const Edit = ({ attributes, setAttributes }) => {
	const { selectField } = attributes;
	const [forms, setForms] = useState([]);
	const [loaded, setLoaded] = useState(false);
	const [error, setError] = useState(false);

	useEffect(() => {
		apiFetch({ path: 'unofficial-convertkit/v1/forms' }).then(
			(data) => {
				setForms(data.forms);
				setLoaded(true);
			},
			() => {
				setError(true);
				createErrorNotice(
					__(
						'Something went bad with the ConvertKit forms.',
						'unofficial-converkit'
					),
					{
						type: 'snackbar',
					}
				);
			}
		);
	});

	//Todo: make the parameter configurable
	const onChangeSelectField = (value) => {
		setAttributes({ selectField: value });
	};

	return (
		<>
			<InspectorControls>
				{!loaded && !error && <Spinner />}
				{loaded && (
					<SelectControl
						label="Form"
						value={selectField}
						options={[
							{
								value: null,
								label: __(
									'Select a form',
									'unofficial-convertkit'
								),
								disabled: true,
							},
							...forms.map((form) => ({
								value: form.uid,
								label: form.name,
							})),
						]}
						onChange={onChangeSelectField}
					/>
				)}
			</InspectorControls>
			{selectField && (
				<SandBox
					key={selectField}
					html={renderToString(ScriptTag(selectField))}
				/>
			)}
		</>
	);
};

export default hot(Edit);
