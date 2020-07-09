<?php

namespace UnofficialConvertKit\Tests\Admin;

use UnofficialConvertKit\Admin\Gutenberg_Hooks;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * @covers \UnofficialConvertKit\Admin\Gutenberg_Hooks::enqueue_assets
 */
class Gutenberg_Hooks_Test extends TestCase {

	public function setUp(): void {
		parent::setUp();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/interface-hooker.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/interface-hooks.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/admin/hooks/class-gutenberg-hooks.php';
	}

	/**
	 * @test
	 * @doesNotPerformAssertions
	 */
	public function from_asset_manifest_to_enqueue_asset_goes_correct() {
		define( 'SCRIPT_DEBUG', true );
		define( 'UNOFFICIAL_CONVERKIT_ASSETS_DIR', __DIR__ . '/mocks' );

		$gutenberg = new Gutenberg_Hooks();

		WP_Mock::userFunction(
			'\UnofficialConvertKit\enqueue_script',
			array(
				'args'   => array(
					'http://example.com/mock-form.js',
					array(
						'dependencies' => array( 'wp' ),
						'version'      => false,
					),
				),
				'return' => null,
			)
		);

		$gutenberg->enqueue_assets();
	}
}
