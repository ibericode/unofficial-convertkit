<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Validation_Error;

use function UnofficialConvertKit\API\V3\is_valid_api_key;
use function UnofficialConvertKit\API\V3\is_valid_api_secret;

class General_Validator extends Admin_Notice_Validator {

	public function __construct() {
		parent::__construct( 'unofficial_convertkit_settings' );
	}

	/**
	 * @inheritDoc
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
}
