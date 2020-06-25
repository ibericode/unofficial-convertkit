<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Integration\Comment_Form_Integration;
use UnofficialConvertKit\Validation_Error;
use UnofficialConvertKit\Validator_Interface;

class Integration_Enabled_Validator implements Validator_Interface {

	private $core_integrations = array(
		Comment_Form_Integration::IDENTIFIER,
	);

	/**
	 * @inheritDoc
	 */
	public function validate( $data ): array {
		if ( empty( $data[ Comment_Form_Integration::IDENTIFIER ] ) ) {
			return array();
		} 
	}

	/**
	 * @inheritDoc
	 */
	public function notice( Validation_Error $error ) {
		// TODO: Implement notice() method.
	}
}
