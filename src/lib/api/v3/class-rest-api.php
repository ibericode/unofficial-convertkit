<?php

namespace UnofficialConvertKit\API\V3;

/**
 * Contains methods with defined resource as end point
 *
 * @package UnofficialConvertKit\API\V3
 *
 * @see https://developers.convertkit.com
 */
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
}
