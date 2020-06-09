<?php

namespace UnofficialConvertKit;

class Admin_Hooks {



	/**
	 * @var Settings_Controller
	 */
	private $controller;

	public function __construct() {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/controller/class-settings-controller.php';

		$this->controller = new Settings_Controller();
	}

	/**
	 * Register all the hooks which belong to the Admin dashboard
	 */
	public function hook() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
	}

	/**
	 * Add page to the side bar.
	 */
	public function add_settings_page() {
		add_options_page(
			__( 'Settings', 'unofficial-convertkit' ),
			'Unofficial ConvertKit',
			'manage_options',
			Settings_Controller::MENU_SLUG,
			array( $this->controller, 'index' )
		);
	}
}
