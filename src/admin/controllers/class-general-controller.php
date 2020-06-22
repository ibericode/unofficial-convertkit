<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\get_default_options;
use function UnofficialConvertKit\get_options;
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
		$options = get_options();

		require __DIR__ . '/../validators/class-general-validator.php';

		if ( ! validate_with_notice( $settings, new General_Validator() ) ) {
			return $options;
		}

		//Filter all the keys which are not needed.
		$filter = array_filter(
			$settings,
			function( $key ) {
				return ! array_key_exists( $key, array_keys( get_default_options() ) );
			},
			ARRAY_FILTER_USE_KEY
		);

		return array_merge( $options, $filter );
	}
}
