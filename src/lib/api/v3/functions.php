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
 *
 * @since 1.0.0
 */
function validate_credentials( string $api_key, string $api_secret ): bool {
	return validate_api_key( $api_key ) && validate_api_secret( $api_secret );
}

/**
 * Checks if the API doesn't return 401
 *
 * @param string $api_key API key to check
 *
 * @return bool true if key is valid other wise false
 *
 * @throws Response_Exception only if the API doesn't return 200 or 401
 * @since 1.0.0
 */
function validate_api_key( string $api_key ): bool {
	$client = new Client( $api_key, '' );

	try {
		$client->get( 'account' );
	} catch ( Unauthorized_Exception $e ) {
		return false;
	} catch ( Response_Exception $e ) {
		throw $e;
	}

	return true;
}

/**
 * Check if the API doesn't return 401 with the secret attached.
 *
 * @param string $api_secret API secret to check
 *
 * @return bool true if secret is valid other wise false
 *
 * @throws Response_Exception only if the API doesn't return 200 or 401
 * @since 1.0.0
 */
function validate_api_secret( string $api_secret ): bool {
	$client = new Client( '', $api_secret );

	try {
		$client->get( 'account' );
	} catch ( Unauthorized_Exception $e ) {
		return false;
	} catch ( Response_Exception $e ) {
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
 *
 * @since 1.0.0
 */
function is_connectable( string $api_key, string $api_secret ): bool {
	$client = new Client( $api_key, $api_secret );

	try {
		$client->get( 'account' );
	} catch ( Response_Exception $e ) {
		return  false;
	}

	return true;
}
