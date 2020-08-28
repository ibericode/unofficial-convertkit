<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\get_asset_src;
use function UnofficialConvertKit\get_default_options;
use function UnofficialConvertKit\get_options;
use function UnofficialConvertKit\is_obfuscated_string;
use function UnofficialConvertKit\obfuscate_string;

class General_Controller {

	/**
	 * Test if the api is contactable.
	 */
	public function info() {
		$options = get_options();

		require __DIR__ . '/../class-connection-status.php';
		$connection = new Connection_Status( $options['api_key'], $options['api_secret'] );

		wp_send_json(
			array(
				'status'  => $connection->status,
				'message' => $connection->message,
				'account' => $connection->get_account(),
			)
		);
	}

	/**
	 * Index of the general tab.
	 */
	public function index() {
		wp_enqueue_script( 'uck_admin', get_asset_src( 'js/admin.js' ) );

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-general-page.php';
		$view( get_options() );
	}

	/**
	 * @param array $new_options
	 *
	 * @return array|void
	 */
	public function save( array $new_options ) {
		$options                   = get_options();
		$new_options               = $this->replace_obfuscated_settings( $new_options, $options );
		$new_options['api_key']    = trim( $new_options['api_key'] );
		$new_options['api_secret'] = trim( $new_options['api_secret'] );
		return array_intersect_key( $new_options, get_default_options() );
	}

	/**
	 * @param array $settings
	 * @param array $options
	 *
	 * @return array
	 *
	 * @see \get_option()
	 */
	private function replace_obfuscated_settings( array $settings, array $options ): array {
		foreach ( array( 'api_key', 'api_secret' ) as $key ) {
			$api_credential = $settings[ $key ] ?? '';

			// if given setting was obfuscated value, replace with value from previous save
			if ( is_obfuscated_string( $api_credential ) && obfuscate_string( $options[ $key ] ) === $api_credential ) {
				$settings[ $key ] = $options[ $key ];
			}
		}

		return $settings;
	}
}
