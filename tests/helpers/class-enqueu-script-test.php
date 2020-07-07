<?php

namespace UnofficialConvertKit\Tests;

use Exception;
use WP_Mock;
use WP_Mock\Tools\TestCase;
use function UnofficialConvertKit\enqueue_script;

class Enqueu_Script_Test extends TestCase {

	public function setUp(): void {
		parent::setUp();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/helpers.php';
	}

	/**
	 * @test
	 * @doesNotPerformAssertions
	 */
	public function generates_correct_asset_path() {
		define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_FILE', __FILE__ );
		define( 'UNOFFICIAL_CONVERKIT_ASSETS_DIR', __DIR__ . '/mocks' );
		$asset = 'mock';
		$url   = 'https://example.com/mock.js';

		$args = array(
			$asset,
			$url,
			array( 'wp' ),
			'123',
		);

		WP_Mock::userFunction(
			'plugins_url',
			array(
				'return' => $url,
			)
		);

		WP_Mock::userFunction(
			'wp_enqueue_script',
			array(
				'args'   => $args,
				'return' => null,
			)
		);

		enqueue_script( $asset );
	}
}
