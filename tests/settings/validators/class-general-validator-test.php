<?php

namespace UnofficialConvertKit\Tests\Settings;

use UnofficialConvertKit\Settings\General_Validator;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * @coversDefaultClass \UnofficialConvertKit\Settings\General_Validator
 */
class General_Validator_Test extends TestCase {

	public function setUp(): void {
		parent::setUp();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/errors/class-validation-error.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/validators/interface-validator.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/settings/validators/class-general-validator.php';
	}

	/**
	 * @test
	 *
	 * @dataProvider data_provider_validate
	 */
	public function validate_api_key_and_secret(
		bool $is_valid_api_key,
		bool $is_valid_api_secret,
		int $excpected
	) {
		WP_Mock::userFunction(
			'UnofficialConvertKit\API\V3\is_valid_api_key',
			array( 'return' => $is_valid_api_key )
		);

		WP_Mock::userFunction(
			'UnofficialConvertKit\API\V3\is_valid_api_secret',
			array( 'return' => $is_valid_api_secret )
		);

		WP_Mock::userFunction(
			'UnofficialConvertKit\is_obfuscated_string',
			array( 'return_in_order' => array( $is_valid_api_key, $is_valid_api_secret ) )
		);

		$validator = new General_Validator();

		$errors = $validator->validate(
			array(
				'api_key'    => 'key',
				'api_secret' => 'secret',
			)
		);

		$this->assertCount( $excpected, $errors );
	}

	public function data_provider_validate() {
		return array(
			array( false, true, 1 ),
			array( true, false, 1 ),
			array( false, false, 2 ),
			array( true, true, 0 ),
		);
	}

	/**
	 * @test
	 *
	 * @dataProvider data_provider_wrong_credentials
	 */
	public function empty_api_credentials_causes_error( string $api_key, string $api_secret, int $excpected ) {
		$validator = new General_Validator();

		$errors = $validator->validate( compact( 'api_key', 'api_secret' ) );

		$this->assertCount( $excpected, $errors );
	}

	public function data_provider_wrong_credentials() {
		return array(
			array( '', '', 2 ),
			array( 'api_key', '', 1 ),
			array( '', 'api_secret', 1 ),
		);
	}
}
