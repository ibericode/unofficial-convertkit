<?php

namespace UnofficialConvertKit;

class Settings_Controller {

	const MENU_SLUG = 'unofficial-convertkit-settings';

	/**
	 * Render the form
	 *
	 * @return void
	 */
	public function index() {
		$tabs = array(
			//Default section
			'general'      => array(
				'i18n'   => __( 'General', 'unofficial-convertkit' ),
				'active' => false,
			),
			'integrations' => array(
				'i18n'   => __( 'Integrations', 'unofficial-convertkit' ),
				'active' => false,
			),
		);

		$active_section                    = array_search( $_GET['tab'] ?? null, $tabs, true ) ?: 'general'; //phpcs:ignore
		$tabs[ $active_section ]['active'] = true;

		$view = require __DIR__ . '/../views/settings/settings-page.php';
		$view( $tabs, $active_section );
	}

	/**
	 * Handles the form.
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function save( array $settings ) {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/validators/settings/class-general-validator.php';

		validate_with_notice( $settings, new General_Validator() );

		return array();
	}
}
