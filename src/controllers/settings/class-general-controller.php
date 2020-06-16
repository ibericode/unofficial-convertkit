<?php

namespace UnofficialConvertKit;

class General_Controller {

	public function index() {
		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/settings/view-general-page.php';
		$view( get_options() );
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	public function save( array $settings ) {
		$options = get_options();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/validators/settings/class-general-validator.php';

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
