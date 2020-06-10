<?php

namespace UnofficialConvertKit;

class General_Validator implements Validator_Interface {

	/**
	 * Validate the form of settings
	 *
	 * @param mixed $data
	 *
	 * @return Validation_Error[]
	 */
	public function validate( $data ) {
		$errors = array();

		$errors[] = new Validation_Error( 'Test 1' );
		$errors[] = new Validation_Error( 'Test 2' );

		return $errors;
	}

	/**
	 * @param Validation_Error $error
	 */
	public function notice( Validation_Error $error ) {
		add_settings_error(
			'unofficial_convertkit_settings',
			null,
			$error->getMessage(),
			$error->getType()
		);
	}
}
