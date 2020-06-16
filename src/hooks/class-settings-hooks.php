<?php

namespace UnofficialConvertKit;

/**
 * Class Settings_Hooks
 * @package UnofficialConvertKit
 */
class Settings_Hooks {

	const MENU_SLUG = 'unofficial-convertkit-settings';

	/**
	 * @var General_Controller
	 */
	private $general_controller;

	/**
	 * @var Integration_Controller
	 */
	private $integration_controller;

	public function __construct() {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/controllers/settings/class-general-controller.php';
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/controllers/settings/class-integration-controller.php';

		$this->general_controller     = new General_Controller();
		$this->integration_controller = new Integration_Controller();
	}

	/**
	 * Register all the hooks which belong to the Settings page
	 */
	public function hook() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'settings_page_unofficial-convertkit-settings', $this->dispatch() );
		add_filter( 'sanitize_option_unofficial_convertkit', array( $this->integration_controller, 'save' ) );
	}

	/**
	 * Add page to the side bar.
	 */
	public function add_settings_page() {
		register_setting(
			'unofficial_convertkit_settings',
			'unofficial_convertkit'
		);

		add_options_page(
			__( 'Settings', 'unofficial-convertkit' ),
			'Unofficial ConvertKit',
			'manage_options',
			self::MENU_SLUG,
			'__return_null'
		);
	}

	/**
	 * @return callable
	 */
	public function dispatch() {

		switch ( $_GET['tab'] ?? 'general' ) {
			case 'general':
				return array( $this->general_controller, 'index' );
			case 'integrations':
				return array( $this->integration_controller, 'index' );
		}
	}
}
