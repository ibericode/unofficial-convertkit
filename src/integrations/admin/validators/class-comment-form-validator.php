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

		if ( isset( $data['form_ids'] ) && ! is_array( $data['form_ids'] ) ) {
			return array(
				new Validation_Error(
					__( 'Convertkit Forms field has an incorrect value.', 'unofficial-convertkit' ),
					'incorrect-form_ids-value'
				),
			);
		}

		return array();
	}
}
