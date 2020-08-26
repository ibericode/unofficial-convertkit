<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\API\V3\Response_Exception;
use function UnofficialConvertKit\API\V3\is_valid_api_key;
use function UnofficialConvertKit\API\V3\is_valid_api_secret;
use function UnofficialConvertKit\Debug\error;

class Connection_Status {

	const NEUTRAL       = 0;
	const CONNECTED     = 1;
	const NOT_CONNECTED = -1;

	public $status  = self::NEUTRAL;
	public $message = '';

	public function __construct( string $api_key, string $api_secret ) {

		if ( '' === $api_key && '' === $api_secret ) {
			return;
		}

		try {
			if ( ! is_valid_api_key( $api_key ) ) {
				$this->status  = self::NOT_CONNECTED;
				$this->message = __( 'Your API key seems invalid.', 'unoffical-convertkit' );
				return;
			}

			if ( ! is_valid_api_secret( $api_secret ) ) {
				$this->status  = self::NOT_CONNECTED;
				$this->message = __( 'Your API secret seems invalid.', 'unoffical-convertkit' );
				return;
			}

			$this->status = self::CONNECTED;
		} catch ( Response_Exception $e ) {
			error( $e->getMessage() );
			$this->status  = self::NOT_CONNECTED;
			$this->message = $e->getMessage();
		}

	}
}
