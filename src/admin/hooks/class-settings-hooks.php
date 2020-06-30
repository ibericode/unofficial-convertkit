<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\get_default_options;
use function UnofficialConvertKit\validate_with_notice;

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
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'settings_page_unofficial-convertkit-settings', array( $this, 'settings_page' ) );

		add_filter( 'sanitize_option_unofficial_convertkit_settings', array( $this->general_controller, 'save' ) );
		//ToDo: redirect if the options does not exists and the API credentials are empty.
		// Because the other page will crash.
		//      $self = ( $_GET['page'] ?? '' ) === Settings_Hooks::MENU_SLUG && ( $_GET['tab'] ?? '' ) === 'general';

		//      if ( ! $self && ! wp_doing_ajax() && ! is_page( 'options.php' ) ) {
		//          add_filter( 'default_option_unofficial_convertkit_settings', array( $this->general_controller, 'empty_credentials' ) );
		//      }

		add_action( 'unofficial_convertkit_settings_tab_general', array( $this->general_controller, 'index' ) );
		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_general_tab' ) );
	}


	/**
	 * Add page to the side bar.
	 *
	 * @internal
	 * @ignore
	 */
	public function add_settings_page() {
		register_setting(
			'unofficial_convertkit',
			'unofficial_convertkit_settings',
			array(
				'type'    => 'array',
				'default' => get_default_options(),
			)
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

		$settings = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-settings-tabs.php';

		$settings( $selected_tab );
	}
}
