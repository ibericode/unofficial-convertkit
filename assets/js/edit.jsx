import React, { useState, useEffect } from 'react';
import { InspectorControls } from '@wordpress/block-editor';
import apiFetch from '@wordpress/api-fetch';
import { dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import * as Components from '@wordpress/components';

const FormSelect = ({ value, forms, onChange }) => (
	<Components.SelectControl
		options={[
			{
				value: 0,
				label: __('Select a form', 'unofficial-convertkit'),
				disabled: true,
			},
			...forms.map(({ id, name }) => ({
				value: id,
				label: name,
			})),
		]}
		value={value}
		onChange={onChange}
	/>
);

const PlaceHolder = ({ forms, disabled, onSubmit, selectFormId, onSelect }) => (
	<Components.Placeholder
		label={__('ConvertKit form', 'unofficial-convertkit')}
		icon="yes"
		instructions={__(
			'Select a ConvertKit form to use.',
			'unofficial-convertkit'
		)}
		isColumnLayout
	>
		{forms.length > 0 ? (
			<Components.Card size="small" style={{ marginBottom: '1rem' }}>
				{forms.map(({ id, name }, index) => {
					const icon = (
						// eslint-disable-next-line jsx-a11y/label-has-for
						<label>
							<input
								type="radio"
								checked={selectFormId === id}
								onChange={() => {}}
							/>
						</label>
					);
					return (
						<React.Fragment key={id}>
							<Components.MenuItem
								style={{ margin: '0' }}
								isSelected={selectFormId === id}
								icon={icon}
								onClick={() => onSelect(id)}
							>
								{name}
							</Components.MenuItem>
							{forms.length - 1 !== index && (
								<Components.HorizontalRule
									style={{ margin: 0 }}
								/>
							)}
						</React.Fragment>
					);
				})}
			</Components.Card>
		) : (
			<div style={{ display: 'grid', placeItems: 'center' }}>
				<Components.Spinner />
			</div>
		)}

		<div>
			<Components.Button
				isSecondary={true}
				disabled={disabled}
				onClick={onSubmit}
			>
				{__('Done', 'unofficial-convertkit')}
			</Components.Button>
		</div>
	</Components.Placeholder>
);

const Preview = ({ html }) => {
	if (null === html) {
		return (
			<div style={{ display: 'grid', placeItems: 'center' }}>
				<Components.Spinner />
			</div>
		);
	}

	if (false === html) {
		return <Components.Placeholder />;
	}

	return <Components.SandBox html={html} />;
};

const Edit = ({ attributes, setAttributes }) => {
	const [forms, setForms] = useState([]);
	const [error, setError] = useState(false);
	const { createErrorNotice } = dispatch('core/notices');
	const [formId, setFormId] = useState(attributes.formId);
	const [html, setHtml] = useState(null);
	const initial = attributes.formId === 0;
	const loaded = forms.length > 0;

	useEffect(() => {
		apiFetch({ path: 'unofficial-convertkit/v1/forms' }).then(
			(data) => {
				setForms(data.forms.filter(({ type }) => type !== 'hosted'));
			},
			() => {
				setError(true);
				createErrorNotice(
					__(
						'Something went bad with the ConvertKit forms.',
						'unofficial-convertkit'
					),
					{
						type: 'snackbar',
					}
				);
			}
		);
	}, []);

	useEffect(() => {
		if (!forms) {
			return; // forms not loaded yet
		}

		if (!formId) {
			setHtml(false);
			return; // no form selected
		}

		const form = forms.filter(({ id }) => id === formId).pop();
		if (!form) {
			setHtml(false);
			return; // selected form ID doesn't exist (anymore)
		}

		// we need the wrapper here to make sure the block controls show-up when hovering
		/* prettier-ignore */
		setHtml(
			`
				<div style="position: relative;">
					<div style="width: 100%; height: 100%; position: absolute; z-index: 900;"></div>
					<div id="loading-indicator" style="color: #666; font-size: 0.8em;">${__(
						'Loading ConvertKit form preview.',
						'unofficial-convertkit'
					)}</div>
					<script async id="convertkit-embed" data-uid="${form.uid}" src="${form.embed_js}"></script>
					<script>
					document.getElementById('convertkit-embed').addEventListener('load', function() {
						document.getElementById('loading-indicator').remove();
					})
					</script>
				</div>`
		);
		/* prettier-ignore */
	}, [formId, forms]);

	const onChangeFormId = (value) => {
		const form = forms.filter(({ id }) => id === parseInt(value)).pop();
		setFormId(form.id);
		setAttributes({
			formId: form.id,
			embedJs: form.embed_js,
			formUid: form.uid,
		});
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
							value={formId}
							forms={forms}
							onChange={onChangeFormId}
						/>
					) : (
						<div style={{ display: 'grid', placeItems: 'center' }}>
							<Components.Spinner />
						</div>
					)}
				</Components.PanelBody>
			</InspectorControls>
			{initial ? (
				<PlaceHolder
					forms={forms}
					onSubmit={() => {
						onChangeFormId(formId);
					}}
					disabled={formId === 0}
					selectFormId={formId}
					onSelect={(id) => {
						setFormId(id);
					}}
				/>
			) : (
				<Preview key={formId} html={html} />
			)}
		</>
	);
};

export default Edit;
