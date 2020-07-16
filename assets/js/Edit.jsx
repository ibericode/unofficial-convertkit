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

const PlaceHolder = ({ forms, onChange, disabled, onClick, selectFormUid }) => (
	<Components.Placeholder
		label={__('ConvertKit form', 'unofficial-convertkit')}
		icon="yes"
		instructions={__(
			'Select a ConvertKit form to use.',
			'unofficial-convertkit'
		)}
		isColumnLayout
	>
		<Components.Card size="small" style={{ marginBottom: '1rem' }}>
			{forms.length > 0 ? (
				forms.map(({ uid, name }, index) => (
					<>
						{/* eslint-disable-next-line jsx-a11y/label-has-for */}
						<label key={uid}>
							<Components.CardBody>
								<input
									type="radio"
									name="unofficial-convertkit-forms"
									onChange={onChange}
									value={uid}
									checked={selectFormUid === uid}
								/>
								{name}
							</Components.CardBody>
						</label>
						{forms.length - 1 !== index && (
							<Components.CardDivider />
						)}
					</>
				))
			) : (
				<Components.CardBody>
					<Components.Spinner />
				</Components.CardBody>
			)}
		</Components.Card>

		<div>
			<Components.Button
				isSecondary={true}
				disabled={disabled}
				onClick={onClick}
			>
				{__('Done', 'unofficial-convertkit')}
			</Components.Button>
		</div>
	</Components.Placeholder>
);

const Edit = ({ attributes, setAttributes }) => {
	const [forms, setForms] = useState([]);
	const [loaded, setLoaded] = useState(false);
	const [error, setError] = useState(false);
	const { createErrorNotice } = dispatch('core/notices');
	const [formUid, setFormUid] = useState(attributes.formUid);
	const [initial, setInitial] = useState(attributes.formUid.length === 0);

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
		setFormUid(value);
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
			{!initial && loaded && formUid.length > 0 ? (
				<Components.SandBox
					key={formUid}
					html={renderToString(
						ScriptTag(forms.find(({ uid }) => uid === formUid))
					)}
				/>
			) : (
				<PlaceHolder
					forms={forms}
					onChange={(e) => onChangeFormUid(e.target.value)}
					disabled={!formUid.length}
					onClick={() => setInitial(false)}
					selectFormUid={formUid}
				/>
			)}
		</>
	);
};

export default hot(Edit);
