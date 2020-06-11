<?php

namespace UnofficialConvertKit\API\V3;

use InvalidArgumentException;
use stdClass;
use WP_Error;

class Client {

	private static $base_url = 'https://api.convertkit.com/v3';

	/**
	 * @var string
	 */
	private $api_key;

	/**
	 * @var string
	 */
	private $api_secret;

	/**
	 * Client constructor
	 *
	 * @param string $api_key Unique token to access general data what doesn't access sensitive data
	 * @param string $api_secret Unique token for privilege endpoints which access sensitive data
	 *
	 * @see https://developers.convertkit.com/#api-key
	 * @see https://developers.convertkit.com/#api-secret
	 */
	public function __construct( string $api_key, string $api_secret ) {
		$this->api_key    = $api_key;
		$this->api_secret = $api_secret;
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method POST
	 *
	 * @param string $resource The URL endpoint
	 * @param array $args The data that the API endpoint will accepts
	 *
	 * @return stdClass
	 *
	 * @see Client::request
	 */
	public function post( string $resource, array $args = array() ): stdClass {
		return $this->request( 'POST', $resource, $args );
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method GET
	 *
	 * @param string $resource
	 * @param array $args
	 *
	 * @return stdClass
	 *
	 * @see Client::request
	 */
	public function get( string $resource, array $args = array() ): stdClass {
		return $this->request( 'GET', $resource, $args );
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method DELETE
	 *
	 * @param string $resource The URL endpoint
	 * @param array $args The data that the API endpoint will accept
	 *
	 * @return stdClass The response data decode from json
	 *
	 * @see Client::request
	 */
	public function delete( string $resource, array $args = array() ): stdClass {
		return $this->request( 'DELETE', $resource, $args );
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method PUT
	 *
	 * @param string $resource The URL endpoint
	 * @param array $args The data that the API endpoint will accept
	 *
	 * @return stdClass The response data decode from json
	 *
	 * @see Client::request
	 */
	public function put( string $resource, array $args = array() ): stdClass {
		return $this->request( 'PUT', $resource, $args );
	}

	/**
	 * Send a HTTP request to ConvertKit v3 API.
	 *
	 * @param string $method The HTTP method e.g GET, DELETE, PUT or POST
	 * @param string $resource The URL endpoint like `account` this method add the first trilling slash and adds the API secret
	 * @param array $args The data that the API endpoint will accept gets converted to json.
	 *
	 * @return stdClass The response decode from json.
	 *
	 * @see https://developers.convertkit.com/#getting-started
	 *
	 * @throws Response_Exception
	 */
	public function request( string $method, string $resource, array $args = array() ): stdClass {

		if ( ! ctype_upper( $method ) ) {
			throw new InvalidArgumentException(
				sprintf( 'method is not uppercase' )
			);
		}

		$url = sprintf(
			'%s/%s?api_key=%s&api_secret=%s',
			static::$base_url,
			ltrim( $resource, '/' ),
			$this->api_key,
			$this->api_secret
		);

		$request = array(
			'headers' => array(
				'user-agent' => 'unofficial-convertkit-wordpress-client',
			),
		);

		if ( ! empty( $args ) ) {
			if ( in_array( $method, array( 'GET', 'DELETE' ), true ) ) {
				$url = add_query_arg( $args, $url );
			} else {
				$request['headers']['Content-Type'] = 'application/json';
				$request['body']                    = json_encode( $args );
			}
		}

		$response = wp_remote_request(
			$url,
			array(
				'method' => $method,
				'body'   => wp_json_encode( $args ),
			)
		);

		if ( $response instanceof WP_Error ) {
			throw new Response_Exception( $response->get_error_message(), $response->get_error_code() );
		}

		$code    = (int) wp_remote_retrieve_response_code( $response );
		$message = wp_remote_retrieve_response_message( $response );
		$body    = json_decode( wp_remote_retrieve_body( $response ) );

		//404 page return html
		if ( 404 !== $code && null === $body ) {
			throw new Response_Exception( 'Body could not be parsed.' );
		}

		$exception = null;

		switch ( $code ) {
			case 200:
				break;
			case 401:
				$exception = Unauthorized_Exception::class;
				break;
			case 404:
				$exception = Not_Found_Exception::class;
				break;
			default:
				$exception = Response_Exception::class;
				break;
		}

		if ( null !== $exception ) {
			throw new $exception( $body['message'] ?? $message );
		}

		//In case of unexpected return type convert it to object.
		return (object) $body;
	}
}
