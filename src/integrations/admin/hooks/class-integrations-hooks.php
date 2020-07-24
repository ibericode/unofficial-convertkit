<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Admin\Settings_Hooks;
use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use UnofficialConvertKit\Integrations\Integration_Repository;
use UnofficialConvertKit\Integrations\Integrations_Hooks as General_Integrations_Hooks;
use UnofficialConvertKit\Integrations\Registration_Form_Integration;

/**
 * All the hooks related to the admin interface for the integrations.
 *
 * Class Integrations_Hooks
 * @package UnofficialConvertKit\Integrations\Admin
 */
class Integrations_Hooks implements Hooks {

	const MENU_SLUG = 'unofficial-convertkit-integrations';

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	public function __construct( Integration_Repository $integration_repository ) {
		$this->integration_repository = $integration_repository;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		add_filter( 'parent_file', array( $this, 'highlight_sub_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_integrations_admin_page' ) );
		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_integration_tab' ) );

		require __DIR__ . '/class-default-integration-hooks.php';
		//Register all the admin page that uses the default options.
		$hooker->add_hook( new Default_Integration_Hooks( Comment_Form_Integration::IDENTIFIER ) );
		$hooker->add_hook( new Default_Integration_Hooks( Registration_Form_Integration::IDENTIFIER ) );

		require __DIR__ . '/class-contact-form-7-hooks.php';
		$hooker->add_hook( new Contact_Form_7_Hooks() );

		require __DIR__ . '/../controllers/class-integrations-controller.php';
		$integration_controller = new Integrations_Controller( $this->integration_repository );
		add_action( 'unofficial_convertkit_settings_tab_integrations', array( $integration_controller, 'index' ) );
		add_action( 'admin_page_unofficial-convertkit-integrations', array( $integration_controller, 'show' ) );
		add_filter( 'sanitize_option_unofficial_convertkit_integrations', array( $integration_controller, 'save' ) );
	}

	/**
	 * Register the integration
	 *
	 * @ignore
	 * @internal
	 */
	public function register_settings() {
		register_setting(
			General_Integrations_Hooks::OPTION_NAME,
			General_Integrations_Hooks::OPTION_NAME,
			array(
				'type' => 'array',
			)
		);
	}

	/**
	 * @param callable $render_tab
	 *
	 * @ignore
	 * @internal
	 */
	public function settings_integration_tab( callable $render_tab ) {
		$render_tab( __( 'Integrations', 'unofficial-convertkit' ), 'integrations' );
	}

	/**
	 * Load the integrations settings pages
	 *
	 * @ignore
	 * @internal
	 */
	public function add_integrations_admin_page() {
		add_submenu_page(
			null,
			'',
			null,
			'manage_options',
			self::MENU_SLUG,
			'__return_null'
		);
	}


	/**
	 * Highlight the unofficial ConvertKit in the sub menu when you are at a integration page.
	 *
	 * @param string $slug
	 *
	 * @return string
	 *
	 * @ignore
	 * @internal
	 */
	public function highlight_sub_menu( string $slug ): string {
		global $pagenow;

		if ( 'options-general.php' === $pagenow && self::MENU_SLUG === $_GET['page'] ) {
			global $submenu_file, $plugin_page;

			$submenu_file = Settings_Hooks::MENU_SLUG;
			$plugin_page  = Settings_Hooks::MENU_SLUG;
		}

		return $slug;
	}
}
