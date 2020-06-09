<?php

namespace UnofficialConvertKit;

class Settings_Controller {

	const MENU_SLUG = 'unofficial-convertkit-settings-page';


	public function index() {

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
			$tabs[ $id ]['active']        = true;
			$tabs['convertkit']['active'] = false;
		}

		require __DIR__ . '/../views/settings/settings-page.php';
	}
}
