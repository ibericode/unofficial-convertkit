<?php

namespace UnofficialConvertKit\API\V3;

use stdClass;

/**
 * Contains methods with method name as resource end point.
 * The API secret and key are appended as arguments.
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
	 * @see https://developers.convertkit.com/#account
	 *
	 * @throws Response_Exception
	 */
	public function account(): stdClass {
		return $this->client->get( 'account', array(), true );
	}

	/**
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#list-forms
	 *
	 * @throws Response_Exception
	 */
	public function list_forms(): stdClass {
		return $this->client->get( 'forms' );
	}

	/**
	 * @param string|int $id form id in ConvertKit
	 *
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#list-forms
	 *
	 * @throws Response_Exception
	 */
	public function list_form( $id ): stdClass {
		$resource = sprintf( 'forms/%s', $id );

		return $this->client->get( $resource );
	}

	/**
	 * @param int $id
	 * @param array $args
	 *
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#add-subscriber-to-a-form
	 *
	 * @throws Response_Exception
	 */
	public function add_form_subscriber( int $id, array $args ): stdClass {
		return $this->client->post(
			sprintf( 'forms/%s/subscribe', $id ),
			$args
		);
	}

	/**
	 * @param array $args
	 *
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#list-tags
	 */
	public function list_tags( array $args = array() ): stdClass {
		return $this->client->get(
			'tags',
			$args
		);
	}

	/**
	 * @param int $id the id of the tag
	 *
	 * @param array $args
	 *
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#tag-a-subscriber
	 */
	public function add_tag_to_subscriber( int $id, array $args ): stdClass {
		return $this->client->post(
			sprintf( 'tags/%s/subscribe', $id ),
			$args
		);
	}

	/**
	 * @param array $args
	 *
	 * @return stdClass
	 *
	 * @see https://developers.convertkit.com/#create-a-tag
	 */
	public function add_tag( array $args ): stdClass {
		return $this->client->post(
			'tags',
			$args
		);
	}
}
