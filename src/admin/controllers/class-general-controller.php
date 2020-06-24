<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\get_default_options;
use function UnofficialConvertKit\get_options;
use function UnofficialConvertKit\is_obfuscated_string;
use function UnofficialConvertKit\validate_with_notice;

class General_Controller {

	public function index() {
		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-general-page.php';
		$view( get_options() );
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function save( array $settings ) {
		//Filter all the keys which are not needed.
		$settings = $this->replace_obfuscated_settings( $settings );

		require __DIR__ . '/../validators/class-general-validator.php';
		if ( ! validate_with_notice( $settings, new General_Validator() ) ) {
			return get_options();
		}

		remove_filter( 'sanitize_option_unofficial_convertkit_settings', array( $this, 'save' ) );

		return array_filter(
			$settings,
			function( $key ) {
				return ! array_key_exists( $key, array_keys( get_default_options() ) );
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	private function replace_obfuscated_settings( array $settings ): array {
		$options = get_options();

		foreach ( array( 'api_key', 'api_secret' ) as $key ) {
			$api_credential = $settings[ $key ] ?? '';

			if ( is_obfuscated_string( $api_credential ) ) {
				$settings[ $key ] = $options[ $key ];
			}
		}

		return $settings;
	}
}
