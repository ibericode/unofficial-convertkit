<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\API\V3\Response_Exception;
use function UnofficialConvertKit\API\V3\is_valid_api_key;
use function UnofficialConvertKit\API\V3\is_valid_api_secret;

class Connection_Status {

	const NEUTRAL = 0;
	const CONNECTED = 1;
	const NOT_CONNECTED = -1;

	public $status = 0;
	public $message = '';

	public function __construct( string $api_key, string $api_secret ) {
		if ( $api_key !== '' || $api_secret !== '' ) {
			try {
				if ( ! is_valid_api_key( $api_key ) ) {
					$this->status = self::NOT_CONNECTED;
					$this->message = __( 'Your API key seems invalid.', 'unoffical-convertkit' );
					return;
				}

				if ( ! is_valid_api_secret( $api_secret ) ) {
					$this->status = self::NOT_CONNECTED;
					$this->message = __( 'Your API secret seems invalid.', 'unoffical-convertkit' );
					return;
				}

				$this->status = self::CONNECTED;
			} catch( Response_Exception $e ) {
				$this->status = self::NOT_CONNECTED;
				$this->message = $e->getMessage();
			}
		}
	}
}
