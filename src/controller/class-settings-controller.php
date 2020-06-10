<?php

namespace UnofficialConvertKit;

class Settings_Controller {

	const MENU_SLUG = 'unofficial-convertkit-settings-page';

	public function index() {

		if ( false === get_option( 'unofficial_convertkit' ) ) {
			add_option( 'unofficial_convertkit' );
		}

		$tabs = array(
			'convertkit'   => array(
				'i18n'   => __( 'ConvertKit', 'unofficial-convertkit' ),
				'active' => false,
			),
			'integrations' => array(
				'i18n'   => __( 'Integrations', 'unofficial-convertkit' ),
				'active' => false,
			),
		);

		$id                    = array_search( $_GET['tab'], $tabs, true ) ?: 'convertkit';
		$tabs[ $id ]['active'] = true;

		$view = require __DIR__ . '/../views/settings/settings-page.php';
		$view( $tabs, $id );
	}
}
