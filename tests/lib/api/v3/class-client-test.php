<?php

namespace UnofficialConvertKit\Tests;

use InvalidArgumentException;
use stdClass;
use UnofficialConvertKit\API\V3\Client;
use UnofficialConvertKit\API\V3\Connection_Exception;
use UnofficialConvertKit\API\V3\Not_Found_Exception;
use UnofficialConvertKit\API\V3\Unauthorized_Exception;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Class Client_Test
 * @package UnofficialConvertKit\Tests
 *
 * @see Client
 */
class Client_Test extends TestCase {

	public function setUp(): void {
		parent::setUp();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/class-rest-api.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/class-client.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/class-response-exception.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/class-not-found-exception.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/class-connection-exception.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/class-unauthorized-exception.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/functions.php';
	}

	/**
	 * @test
	 */
	public function api_key_and_secret_can_not_be_both_empty() {
		$this->expectException( InvalidArgumentException::class );

		new Client( '', '' );
	}

	/**
	 * @test
	 *
	 * @dataProvider response_data_provider
	 */
	public function throws_exception_when_certain_http_status_codes_are_returned(
		string $exception,
		string $code,
		string $response_file
	) {
		$this->expectException( $exception );

		WP_Mock::userFunction( 'add_query_arg' )->andReturn( Client::API_BASE_URL );

		WP_Mock::userFunction( 'wp_remote_request' )->andReturn( array() );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_code' )->andReturn( $code );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_message' )->andReturn( '' );

		WP_Mock::userFunction( 'wp_remote_retrieve_body' )->andReturn( file_get_contents( __DIR__ . '/mock/' . $response_file ) );

		$client = new Client( 'api_key', '' );

		$client->get( 'account' );
	}

	/**
	 * @test
	 */
	public function handles_http_status_code_200_fine() {
		WP_Mock::userFunction( 'add_query_arg' )->andReturn( Client::API_BASE_URL );

		WP_Mock::userFunction( 'wp_remote_request' )->andReturn( array() );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_code' )->andReturn( '200' );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_message' )->andReturn( 'OK' );

		WP_Mock::userFunction( 'wp_remote_retrieve_body' )->andReturn( '{}' );

		$client = new Client( 'api_key', '' );

		$response = $client->get( 'account' );

		$this->assertInstanceOf( stdClass::class, $response );
	}

	/**
	 * @return array[]
	 */
	public function response_data_provider() {
		return array(
			array( Unauthorized_Exception::class, '401', 'unauthorised_response.json' ),
			array( Not_Found_Exception::class, '404', '404.html' ),
			array( Connection_Exception::class, '500', '500.html' ),
		);
	}
}
