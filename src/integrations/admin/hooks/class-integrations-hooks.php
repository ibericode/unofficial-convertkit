<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Admin\Settings_Hooks;
use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use UnofficialConvertKit\Integrations\Integration;
use UnofficialConvertKit\Integrations\Integration_Repository;

class Integrations_Hooks implements Hooks {

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	/**
	 * @var array is used to highlight the submenu `settings > unofficial-convertkit` when is you are on another page.
	 */
	private $integration_settings_pages = array();

	public function __construct( Integration_Repository $integration_repository ) {
		$this->integration_repository = $integration_repository;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {

		$integrations = $this->integration_repository;

		add_filter( 'parent_file', array( $this, 'highlight_sub_menu' ) );
		add_action( 'admin_menu', array( $this, 'add_integrations_admin_pages' ) );

		require __DIR__ . '/class-comment-form-hooks.php';

		$hooker->add_hook(
			new Comment_Form_Hooks(
				$integrations->get_by_identifier( Comment_Form_Integration::IDENTIFIER )
			)
		);

		require __DIR__ . '/../controllers/class-integration-controller.php';

		$integration_controller = new Integration_Controller( $integrations, $this->integration_settings_pages );

		add_action(
			'unofficial_convertkit_settings_tab_integrations',
			array( $integration_controller, 'index' )
		);

		add_action(
			'sanitize_option_unofficial_convertkit_integration_enabled',
			array( $integration_controller, 'save_enabled' )
		);

		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_integration_tab' ) );

		add_action( 'admin_init', array( $this, 'register_settings_enabled_integrations' ) );
	}

	/**
	 * Register the settings for the enabled plugins
	 *
	 * @internal
	 * @ignore
	 */
	public function register_settings_enabled_integrations() {
		\register_setting(
			'unofficial_convertkit_integration',
			'unofficial_convertkit_integration_enabled',
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
		$render_tab( __( 'Integrations', 'unofficial-converkit' ), 'integrations' );
	}

	/**
	 * Load the integrations settings pages
	 *
	 * @ignore
	 * @internal
	 */
	public function add_integrations_admin_pages() {
		/**
		 * @param string $page The page name
		 * @param Integration $integration
		 */
		$add_submenu_page = function( string $page, Integration $integration ) {
			add_submenu_page(
				null,
				$integration->get_name(),
				null,
				'manage_options',
				$page,
				'__return_null'
			);

			$this->integration_settings_pages[] = $page;
		};

		foreach ( $this->integration_repository->get_all() as $integration ) {

			$id = $integration->get_identifier();

			if ( ! has_action( 'unofficial_convertkit_integrations_admin_' . $id ) ) {
				continue;
			}

			/**
			 * Add the integration settings page
			 *
			 * @param callable $add_submenu_page Small helper to add submenu page
			 * @param Integration $integration The integration
			 */
			do_action(
				'unofficial_convertkit_integrations_admin_' . $id,
				$add_submenu_page,
				$integration
			);

		}
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
		if ( in_array( $_GET['page'] ?? '', $this->integration_settings_pages, true ) ) {
			global $submenu_file, $plugin_page;

			$submenu_file = Settings_Hooks::MENU_SLUG;
			$plugin_page  = Settings_Hooks::MENU_SLUG;
		}

		return $slug;
	}
}
