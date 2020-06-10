<?php

namespace UnofficialConvertKit;

class General_Validator implements Validator_Interface {

	/**
	 * Validate the form of settings
	 *
	 * @param array $data
	 *
	 * @return Validation_Error[]
	 */
	public function validate( $data ): array {
		$errors = array();

		if ( empty( $data['api_key'] ) ) {
			$errors[] = new Validation_Error(
				__( 'Your API key could not be empty.', 'unofficial-convertkit' ),
				'api-key-empty'
			);
		}

		if ( empty( $data['api_secret'] ) ) {
			$errors[] = new Validation_Error(
				__( 'Your API secret could not be empty.', 'unofficial-convertkit' ),
				'api-secret-empty'
			);
		}

		return $errors;
	}

	/**
	 * @param Validation_Error $error
	 */
	public function notice( Validation_Error $error ) {
		add_settings_error(
			'unofficial_convertkit_settings',
			$error->getKey(),
			$error->getMessage(),
			$error->getType()
		);
	}
}
