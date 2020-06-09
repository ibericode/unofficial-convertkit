<?php

namespace UnofficialConvertKit;

class Settings_Controller {

	const MENU_SLUG = 'unofficial-convertkit-settings-page';

	public function index() {

		if ( false === get_option( 'unofficial_convertkit' ) ) {
			add_option( 'unofficial_convertkit' );
		}

		$default = 'convertkit';

		$tabs = array(
			'convertkit'   => array(
				'i18n'   => __( 'ConvertKit', 'unofficial-convertkit' ),
				'active' => true,
			),
			'integrations' => array(
				'i18n'   => __( 'Integrations', 'unofficial-convertkit' ),
				'active' => false,
			),
		);

		$id = array_search( $_GET['tab'], $tabs, true );

		if ( false !== $id ) {
			$tabs[ $id ]['active']      = true;
			$tabs[ $default ]['active'] = false;
		}

		$active_section = array(
			'template' => require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/settings/section/section-converkit.php',
			'args'     => array(),
		);

		$view = require __DIR__ . '/../views/settings/settings-page.php';
		$view( $tabs, $active_section );
	}
}
