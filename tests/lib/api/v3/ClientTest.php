<?php

namespace UnofficialConvertKit\Tests\lib\api\v3;

use UnofficialConvertKit\API\V3\Client;
use UnofficialConvertKit\API\V3\Not_Found_Exception;
use UnofficialConvertKit\API\V3\Unauthorized_Exception;
use WP_Mock;
use WP_Mock\Tools\TestCase;

class ClientTest extends TestCase {

	/**
	 * @test
	 */
	public function throws_unauthorised_exception_when_API_key_is_invalid() {
		$this->expectException( Unauthorized_Exception::class );

		$api_key = 'invalid_key';

		WP_Mock::userFunction( 'add_query_arg' )
			   ->andReturn( Client::API_BASE_URL );

		WP_Mock::userFunction( 'wp_remote_request' )
				->andReturn( array() );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_code' )
				->andReturn( '401' );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_message' )
				->andReturn( 'Unauthorised' );

		WP_Mock::userFunction( 'wp_remote_retrieve_body' )
				->andReturn( file_get_contents( __DIR__ . '/mock/unauthorised_response.json' ) );

		$client = new Client( $api_key, '' );

		$client->get( 'account' );
	}

	/**
	 * @test
	 */
	public function throws_not_found_exception_on_non_existing_resource() {
		$this->expectException( Not_Found_Exception::class );

		WP_Mock::userFunction( 'add_query_arg' )
			   ->andReturn( Client::API_BASE_URL );

		WP_Mock::userFunction( 'wp_remote_request' )
			   ->andReturn( array() );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_code' )
			   ->andReturn( '404' );

		WP_Mock::userFunction( 'wp_remote_retrieve_response_message' )
			   ->andReturn( 'Not found' );

		WP_Mock::userFunction( 'wp_remote_retrieve_body' )
			   ->andReturn( file_get_contents( __DIR__ . '/mock/404.html' ) );

		$client = new Client( 'api_key', '' );

		$client->get( 'account' );
	}
}
