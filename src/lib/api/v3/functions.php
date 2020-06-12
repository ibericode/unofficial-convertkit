<?php

namespace UnofficialConvertKit\API\V3;

use InvalidArgumentException;

/**
 * Check if the user api key and secret are usable.
 *
 * @param string $api_key
 * @param string $api_secret
 *
 * @return bool
 *
 * @see Client
 *
 * @throws Response_Exception when other error occurs rather than unauthorized exception
 */
function validate_credentials( string $api_key, string $api_secret ): bool {

	if ( empty( $api_key ) ) {
		throw new InvalidArgumentException(
			'Variable $api_key can\'t be empty, empty string given.'
		);
	}

	if ( empty( $api_secret ) ) {
		throw new InvalidArgumentException(
			'Variable $api_secret can\'t be empty, empty string given.'
		);
	}

	//Two request because the api has enough on one correct authentication token.
	$clients = array(
		new Client( '', $this->api_secret ),
		new Client( $this->api_key, '' ),
	);


	try {

		foreach ( $clients as $client ) {
			$client->get( 'account' );
		}
	} catch ( Unauthorized_Exception $e ) {
		return false;
	} catch ( Response_Exception $e ) {
		//Rethrow
		throw $e;
	}

	return true;
}

/**
 * Checks if the API is reachable, return false on any response exception
 *
 * @param string $api_key
 * @param string $api_secret
 *
 * @return bool return true if no response exception has thrown other wise false
 *
 * @see Client
 */
function is_connected( string $api_key, string $api_secret ): bool {
	$client = new Client( $api_key, $api_secret );

	try {
		$client->get( 'account' );
	} catch ( Response_Exception $e ) {
		return  false;
	}

	return true;
}
