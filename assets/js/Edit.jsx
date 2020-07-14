import { hot } from 'react-hot-loader/root';
import React, { useState, useEffect } from 'react';
import { InspectorControls } from '@wordpress/block-editor';
import apiFetch from '@wordpress/api-fetch';
import { renderToString } from '@wordpress/element';
import { dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import * as Components from '@wordpress/components';

const ScriptTag = ({ uid, embed_js: embedJs }) => (
	<script async data-uid={uid} src={embedJs} />
);

const FormSelect = ({ value, forms, onChange }) => (
	<Components.SelectControl
		options={[
			{
				value: '',
				label: __('Select a form', 'unofficial-convertkit'),
				disabled: true,
			},
			...forms.map(({ uid, name }) => ({
				value: uid,
				label: name,
			})),
		]}
		{...{ onChange, value }}
	/>
);

const Edit = ({ attributes, setAttributes }) => {
	const { formUid } = attributes;
	const [forms, setForms] = useState([]);
	const [loaded, setLoaded] = useState(false);
	const [error, setError] = useState(false);
	const { createErrorNotice } = dispatch('core/notices');

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
	}, []);

	const onChangeFormUid = (value) => {
		setAttributes({ formUid: value });
	};

	return (
		<>
			<InspectorControls>
				<Components.PanelBody
					title={__('Form', 'unofficial-convertkit')}
					opened
				>
					{loaded && !error ? (
						<FormSelect
							value={formUid}
							forms={forms}
							onChange={onChangeFormUid}
						/>
					) : (
						<Components.Spinner />
					)}
				</Components.PanelBody>
			</InspectorControls>
			{loaded > 0 && formUid.length > 0 ? (
				<Components.SandBox
					key={formUid}
					html={renderToString(
						ScriptTag(forms.find(({ uid }) => uid === formUid))
					)}
				/>
			) : (
				<Components.Placeholder
					label={__('ConvertKit form', 'unofficial-convertkit')}
					icon="yes"
					instructions={__(
						'Select a ConvertKit form to use.',
						'unofficial-convertkit'
					)}
				>
					<Components.MenuGroup>
						<Components.TextControl
							label={__(
								'Select the form',
								'unofficial-convertkit'
							)}
						/>
						{loaded ? (
							forms.map(({ uid, name }) => (
								<Components.MenuItem
									style={{ 'background-color': 'white' }}
									role="menuitemradio"
									key={uid}
								>
									{name}
								</Components.MenuItem>
							))
						) : (
							<Components.Spinner />
						)}
					</Components.MenuGroup>
					<Components.Button isPrimary={true}>
						{__('Done', 'unofficial-convertkit')}
					</Components.Button>
				</Components.Placeholder>
			)}
		</>
	);
};

export default hot(Edit);
