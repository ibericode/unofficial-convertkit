import { hot } from 'react-hot-loader/root';
import React, { useEffect } from 'react';
import { InspectorControls } from '@wordpress/editor';
import apiFetch from '@wordpress/api-fetch';
import { renderToString, useState } from '@wordpress/element';
import { dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import {
	SelectControl,
	SandBox,
	Spinner,
	PanelBody,
} from '@wordpress/components';

const { createErrorNotice } = dispatch('core/notices');

const ScriptTag = ({ uid, embed_js: embedJs }) => (
	<script async data-uid={uid} src={embedJs} />
);

const Edit = ({ attributes, setAttributes }) => {
	const { formIndex } = attributes;
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
		setAttributes({ formIndex: value, formUid: forms[value].uid || null });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Form', 'unofficial-convertkit')} opened>
					{!loaded && !error && <Spinner />}
					{loaded && (
						<SelectControl
							value={formIndex || -1}
							options={[
								{
									value: -1,
									label: __(
										'Select a form',
										'unofficial-convertkit'
									),
									disabled: true,
								},
								...forms.map((form, index) => ({
									value: index,
									label: form.name,
								})),
							]}
							onChange={onChangeSelectField}
						/>
					)}
				</PanelBody>
			</InspectorControls>
			{formIndex ? (
				<SandBox
					key={formIndex}
					html={renderToString(ScriptTag(forms[formIndex]))}
				/>
			) : (
				//Todo: select the correct one
				<div>Select one of the following</div>
			)}
		</>
	);
};

export default hot(Edit);
