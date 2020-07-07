<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\get_default_options;

class Settings_Hooks implements Hooks {

	const MENU_SLUG = 'unofficial-convertkit-settings';

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_general_tab' ) );

		require __DIR__ . '/../controllers/class-settings-controller.php';
		$settings_controller = new Settings_Controller();
		add_action( 'settings_page_unofficial-convertkit-settings', array( $settings_controller, 'index' ) );
		add_action( 'default_option_unofficial_convertkit_settings', array( $settings_controller, 'redirect_by_empty_options' ) );

		require __DIR__ . '/../controllers/class-general-controller.php';
		$general_controller = new General_Controller();
		add_filter( 'sanitize_option_unofficial_convertkit_settings', array( $general_controller, 'save' ) );
		add_action( 'unofficial_convertkit_settings_tab_general', array( $general_controller, 'index' ) );

		require __DIR__ . '/class-gutenberg-hooks.php';
		$hooker->add_hook( new Gutenberg_Hooks() );
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
	 *
	 * @ignore
	 * @internal
	 */
	public function settings_general_tab( callable $render_tab ) {
		$render_tab( __( 'General', 'unofficial-converkit' ), 'general' );
	}
}
