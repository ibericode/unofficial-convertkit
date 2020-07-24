import { hot } from 'react-hot-loader/root';
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
						'unofficial-converkit'
					),
					{
						type: 'snackbar',
					}
				);
			}
		);
	}, []);

	useEffect(() => {
		apiFetch({
			path: `unofficial-convertkit/v1/forms/${formId}/render`,
		}).then(({ rendered }) => {
			setHtml(rendered);
		});
	}, [formId]);

	const onChangeFormId = (value) => {
		setHtml(null);

		const id = parseInt(value);

		setFormId(id);
		setAttributes({ formId: id });
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

export default process.env.NODE_ENV === 'development' ? hot(Edit) : Edit;
