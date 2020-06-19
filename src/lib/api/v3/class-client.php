<?php

namespace UnofficialConvertKit\API\V3;

use InvalidArgumentException;
use stdClass;
use WP_Error;

final class Client {

	const API_BASE_URL = 'https://api.convertkit.com/v3';

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
		if ( empty( $api_key ) && empty( $api_secret ) ) {
			throw new InvalidArgumentException(
				'$api_key and $api_secret can not be both empty, provide at least one.'
			);
		}

		$this->api_key    = $api_key;
		$this->api_secret = $api_secret;
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method POST
	 *
	 * @param string $resource The URL endpoint
	 * @param array $args The data that the API endpoint will accepts
	 * @param bool $needs_api_secret
	 *
	 * @return stdClass
	 *
	 * @since 1.0.0
	 * @see Client::request
	 */
	public function post( string $resource, array $args = array(), bool $needs_api_secret = false ): stdClass {
		return $this->request( 'POST', $resource, $args, $needs_api_secret );
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method GET
	 *
	 * @param string $resource The path endpoint
	 * @param array $args Will be added as query arguments
	 * @param bool $needs_api_secret
	 *
	 * @return stdClass
	 *
	 * @since 1.0.0
	 * @see Client::request
	 */
	public function get( string $resource, array $args = array(), bool $needs_api_secret = false ): stdClass {
		return $this->request( 'GET', $resource, $args, $needs_api_secret );
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method DELETE
	 *
	 * @param string $resource The path endpoint
	 * @param array $args The data that the API endpoint will accept
	 * @param bool $needs_api_secret
	 *
	 * @return stdClass The response data decode from json
	 *
	 * @since 1.0.0
	 * @see Client::request
	 */
	public function delete( string $resource, array $args = array(), bool $needs_api_secret = false ): stdClass {
		return $this->request( 'DELETE', $resource, $args, $needs_api_secret );
	}

	/**
	 * Send a HTTP request to the ConvertKit v3 API with HTTP method PUT
	 *
	 * @param string $resource The path endpoint
	 * @param array $args The data that the API endpoint will accept
	 * @param bool $needs_api_secret
	 *
	 * @return stdClass The response data decode from json
	 *
	 * @since 1.0.0
	 * @see Client::request
	 */
	public function put( string $resource, array $args = array(), bool $needs_api_secret = false ): stdClass {
		return $this->request( 'PUT', $resource, $args, $needs_api_secret );
	}

	/**
	 * Send a HTTP request to ConvertKit v3 API.
	 *
	 * @param string $method The HTTP method e.g GET, DELETE, PUT or POST
	 * @param string $resource The path endpoint like `account` this method add the first trilling slash and adds the API secret
	 * @param array $args The data that the API endpoint will accept gets converted to json.
	 * @param bool $needs_api_secret some API endpoints need the api secret mostly for sensitive data
	 *
	 * @return stdClass The response decode from json.
	 *
	 * @see https://developers.convertkit.com/#getting-started
	 *
	 */
	private function request( string $method, string $resource, array $args = array(), bool $needs_api_secret = false ): stdClass {

		$url = $this->build_url( $resource, $needs_api_secret );

		$user_agent = sprintf( 'unofficial-convertkit-wordpress-client/%', UNOFFICIAL_CONVERTKIT_VERSION );

		$request = array(
			'method'  => $method,
			'headers' => array(
				'user-agent' => $user_agent,
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

		$response = wp_remote_request( $url, $request );

		if ( $response instanceof WP_Error ) {
			throw new Response_Exception( $response->get_error_message() );
		}

		$code    = (int) wp_remote_retrieve_response_code( $response );
		$message = wp_remote_retrieve_response_message( $response );
		$body    = json_decode( wp_remote_retrieve_body( $response ) );

		//404 and maybe 500 too? pages returns html
		if ( ! in_array( $code, array( 404, 500 ), true ) && null === $body ) {
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
			case 500:
				$exception = Connection_Exception::class;
				break;
			default:
				$exception = Response_Exception::class;
				break;
		}

		if ( null !== $exception ) {
			throw new $exception( $body->message ?? $message, $code );
		}

		//In case of unexpected return type convert it to object.
		return (object) $body;
	}

	/**
	 * Build the url.
	 *
	 * @param string $resource The path of the URL
	 * @param bool $needs_api_secret Some API endpoints need the api secret
	 *
	 * @return string The url with api key and or secret append as URL query.
	 */
	private function build_url( string $resource, bool $needs_api_secret ): string {
		$url = sprintf(
			'%s/%s',
			static::API_BASE_URL,
			ltrim( $resource, '/' )
		);

		$param = array();

		if ( $needs_api_secret && ! empty( $this->api_secret ) ) {
			$param['api_secret'] = $this->api_secret;
		} else {
			$param['api_key'] = $this->api_key;
		}

		return add_query_arg( $param, $url );
	}
}
