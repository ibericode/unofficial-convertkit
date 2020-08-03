<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\get_default_options;
use function UnofficialConvertKit\get_options;
use function UnofficialConvertKit\is_obfuscated_string;
use function UnofficialConvertKit\obfuscate_string;
use function UnofficialConvertKit\validate_with_notice;

class General_Controller {

	public function index() {
		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-general-page.php';
		$view( get_options() );
	}

	/**
	 * @param array $settings
	 *
	 * @return array|void
	 */
	public function save( array $settings ) {
		$options = get_options();

		//Filter all the keys which are not needed.
		$settings = $this->replace_obfuscated_settings( $settings, $options );

		require __DIR__ . '/../validators/class-general-validator.php';
		if ( ! validate_with_notice( $settings, new General_Validator() ) ) {
			//If we return the old value it will not be saved
			return $options;
		}

		//Why? When is created the callback is still in the array and is called twice because the update and add hook are called
		remove_filter( 'sanitize_option_unofficial_convertkit_settings', array( $this, 'save' ) );

		return array_intersect_key($settings, get_default_options());
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
