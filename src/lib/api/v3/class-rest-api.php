<?php

namespace UnofficialConvertKit\API\V3;

class REST_API {

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * REST_API constructor.
	 *
	 * @param string $api_key
	 * @param string $api_secret
	 */
	public function __construct( string $api_key, string $api_secret ) {
		$this->client = new Client( $api_key, $api_secret );
	}

	/**
	 * Check if the user api key and secret are usable.
	 *
	 * @return bool
	 *
	 * @throws Unauthorized_Exception
	 */
	public function validate_credentials(): bool {

		try {
			$this->client->get( 'account' );
		} catch ( Unauthorized_Exception $e ) {
			throw $e;
		} catch ( Response_Exception $e ) {
			return false;
		}
		
		return true;
	}
}
