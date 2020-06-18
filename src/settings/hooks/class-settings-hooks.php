<?php

namespace UnofficialConvertKit\Settings;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

/**
 * Class Settings_Hooks
 * @package UnofficialConvertKit
 */
class Settings_Hooks implements Hooks {

	const MENU_SLUG = 'unofficial-convertkit-settings';

	/**
	 * @var General_Controller
	 */
	private $general_controller;

	public function __construct() {
		require __DIR__ . '/../controllers/class-general-controller.php';

		$this->general_controller = new General_Controller();
	}

	/**
	 * Register all the hooks which belong to the Settings page
	 *
	 * @param Hooker $hooker
	 */
	public function hook( Hooker $hooker ) {
		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'settings_page_unofficial-convertkit-settings', array( $this, 'settings_page' ) );

		//General
		add_filter( 'sanitize_option_unofficial_convertkit', array( $this->general_controller, 'save' ) );
		add_action( 'unofficial_convertkit_settings_tab_general', array( $this->general_controller, 'index' ) );
		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_general_tab' ) );
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
	 * @param callable $render_tab
	 */
	public function settings_general_tab( callable $render_tab ) {
		$render_tab( __( 'General', 'unofficial-converkit' ), 'general' );
	}

	/**
	 * Render the settings page
	 */
	public function settings_page() {
		$selected_tab = $_GET['tab'] ?? 'general';

		$settings = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/settings/view-settings-tabs.php';

		$settings( $selected_tab );
	}
}
