<?php

namespace UnofficialConvertKit\API\V3;

use stdClass;

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

	/**
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#list-forms
	 *
	 * @throws Response_Exception
	 */
	public function lists_forms(): stdClass {
		return $this->client->post( 'forms' );
	}
}
