<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Admin\Admin_Notice_Validator;
use UnofficialConvertKit\Validation_Error;

class Comment_Form_Validator extends Admin_Notice_Validator {

	public function __construct() {
		parent::__construct( 'unofficial_convertkit_integration_comment_form' );
	}

	/**
	 * @inheritDoc
	 */
	public function validate( $data ): array {
		if ( ! (bool) $data['enabled'] ?? false ) {
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

		if ( ! empty( $data['checkbox-label'] ) ) {
			$errors[] =
				new Validation_Error(
					__( 'Checkbox label is missing.', 'unofficial-convertkit' ),
					'missing-checkbox-label'
				);
		}

		if ( ! is_string( $data['checkbox-label'] ) ) {
			$errors[] =
				new Validation_Error(
					__( 'Checkbox label field has an incorrect value.', 'unofficial-convertkit' ),
					'incorrect-checkbox-label-value'
				);
		}

		return $errors;
	}
}
