<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Admin\Admin_Notice_Validator;
use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use UnofficialConvertKit\Validation_Error;

class Integration_Enabled_Validator extends Admin_Notice_Validator {

	private $core_integrations = array(
		Comment_Form_Integration::IDENTIFIER,
	);


	public function __construct() {
		parent::__construct( 'unofficial_convertkit_integration' );
	}

	/**
	 * @inheritDoc
	 */
	public function validate( $data ): array {
		//Todo: For all default integrations
		$option = 'comment_form';

		if ( ! isset( $data[ $option ] ) ) {
			return array(
				new Validation_Error(
					__( 'Enabled field is missing.', 'unofficial_convertkit' ),
					'enabled-field-missing'
				),
			);
		}

		return array();
	}
}
