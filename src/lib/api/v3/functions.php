<?php

namespace UnofficialConvertKit\API\V3;

/**
 * Sends request with the key and checks if the API doesn't return 401.
 *
 * @param string $api_key API key to check
 *
 * @return bool true if key is valid other wise false
 *
 * @throws Response_Exception only if the API doesn't return 200 or 401
 * @since 1.0.0
 */
function is_valid_api_key( string $api_key ): bool {
	if ( '' === $api_key ) {
		return false;
	}

	$client = new Client( $api_key, '' );

	try {
		$client->get( 'forms' );
	} catch ( Unauthorized_Exception $e ) {
		return false;
	} catch ( Response_Exception $e ) {
		throw $e;
	}

	return true;
}

/**
 * Send request with the secret and checks if the API doesn't return 401.
 *
 * @param string $api_secret API secret to check
 *
 * @return bool true if secret is valid other wise false
 *
 * @throws Response_Exception only if the API doesn't return 200 or 401
 * @since 1.0.0
 */
function is_valid_api_secret( string $api_secret ): bool {
	if ( '' === $api_secret ) {
		return false;
	}

	$client = new Client( '', $api_secret );

	try {
		$client->get( 'account', array(), true );
	} catch ( Unauthorized_Exception $e ) {
		return false;
	} catch ( Response_Exception $e ) {
		throw $e;
	}

	return true;
}
