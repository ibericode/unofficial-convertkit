<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Admin\Admin_Notice_Validator;
use UnofficialConvertKit\Validation_Error;

class Default_Integration_Validator extends Admin_Notice_Validator {

	/**
	 * @var bool
	 */
	private $uses_enabled;

	public function __construct( bool $uses_enabled = true ) {
		parent::__construct( 'unofficial_convertkit_integrations' );
		$this->uses_enabled = $uses_enabled;
	}

	/**
	 * Validate the data of the options of the integrations.
	 * If the integration has more options than extend this class.
	 *
	 * @param mixed $data
	 *
	 * @return array
	 */
	public function validate( $data ): array {
		if ( $this->uses_enabled && ! (bool) $data['enabled'] ?? false ) {
			return array();
		}

		$errors = array();

		if ( isset( $data['form_ids'] ) && ! is_array( $data['form_ids'] ) ) {
			$errors[] =
				new Validation_Error(
					__( 'Convertkit forms field has an incorrect value.', 'unofficial-convertkit' ),
					'incorrect-form-ids-value'
				);
		}

		if ( empty( $data['checkbox-label'] ) ) {
			$errors[] =
				new Validation_Error(
					__( 'Checkbox label is missing.', 'unofficial-convertkit' ),
					'missing-checkbox-label'
				);
		} elseif ( ! is_string( $data['checkbox-label'] ) ) {
			$errors[] =
				new Validation_Error(
					__( 'Checkbox label field has an incorrect value.', 'unofficial-convertkit' ),
					'incorrect-checkbox-label-value'
				);
		}

		return $errors;

	}
}
