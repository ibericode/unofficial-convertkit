<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Validation_Error;
use UnofficialConvertKit\Validator_Interface;

use function UnofficialConvertKit\API\V3\is_valid_api_key;
use function UnofficialConvertKit\API\V3\is_valid_api_secret;
use function UnofficialConvertKit\is_obfuscated_string;

class General_Validator implements Validator_Interface {

	/**
	 * Validate the form of settings
	 *
	 * @param array $data
	 *
	 * @return Validation_Error[]
	 */
	public function validate( $data ): array {
		$api_key    = $data['api_key'] ?? null;
		$api_secret = $data['api_secret'] ?? null;

		$errors = array();

		if ( empty( $api_key ) ) {
			$errors[] = new Validation_Error(
				__( 'Your API key can not be empty.', 'unofficial-convertkit' ),
				'api-key-empty'
			);
		}

		if ( empty( $api_secret ) ) {
			$errors[] = new Validation_Error(
				__( 'Your API secret can not be empty.', 'unofficial-convertkit' ),
				'api-secret-empty'
			);
		}

		//Don't fire a lot of errors.
		if ( count( $errors ) > 0 ) {
			return $errors;
		}

		if ( ! is_valid_api_key( $api_key ) ) {
			$errors[] = new Validation_Error(
				__( 'Your API key is invalid.', 'unofficial-convertkit' ),
				'api-key-invalid'
			);
		}

		if ( ! is_valid_api_secret( $api_secret ) ) {
			$errors[] = new Validation_Error(
				__( 'Your API secret is invalid.', 'unofficial-convertkit' ),
				'api-secret-invalid'
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
