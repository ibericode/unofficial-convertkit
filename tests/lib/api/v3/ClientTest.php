<?php

namespace UnofficialConvertKit\Tests\lib\api\v3;

use InvalidArgumentException;
use UnofficialConvertKit\API\V3\Client;
use UnofficialConvertKit\API\V3\Not_Found_Exception;
use UnofficialConvertKit\API\V3\Unauthorized_Exception;
use WP_Mock;
use WP_Mock\Tools\TestCase;

class ClientTest extends TestCase {

	/**
	 * @test
	 */
	public function api_key_and_secret_can_not_be_empty() {
		$this->expectException( InvalidArgumentException::class );

		new Client( '', '' );
	}

	/**
	 * @test
	 *
	 * @dataProvider responseProvider
	 */
	public function throws_exception_when_certain_http_status_codes_are_returned( string $exception, string $code, string $message, string $response_file ) {
		$this->expectException( $exception );

		WP_Mock::userFunction( 'add_query_arg' )
		       ->andReturn( Client::API_BASE_URL );

		WP_Mock::userFunction( 'wp_remote_request' )
		       ->andReturn( array() );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_code' )
		       ->andReturn( $code );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_message' )
		       ->andReturn( $message );

		WP_Mock::userFunction( 'wp_remote_retrieve_body' )
		       ->andReturn( file_get_contents( __DIR__ . '/mock/'. $response_file ) );

		$client = new Client( 'api_key', '' );

		$client->get( 'account' );
	}

	/**
	 * @return array[]
	 */
	public function responseProvider() {
		return array(
			array( Unauthorized_Exception::class, '401', 'Unauthorised', 'unauthorised_response.json'),
			array( Not_Found_Exception::class, '404', 'Not Found', '404.html')
		);
	}
}
