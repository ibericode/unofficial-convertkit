<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Admin\Settings_Hooks;
use UnofficialConvertKit\Integration\Comment_Form_Integration;
use UnofficialConvertKit\Integration\Integration;
use UnofficialConvertKit\Integration\Integration_Repository;

class Integrations_Hooks implements Hooks {

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

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
		add_action( 'admin_menu', array( $this, 'add_integrations_settings_pages' ) );

		require __DIR__ . '/class-comment-form-hooks.php';

		$hooker->add_hook(
			new Comment_Form_Hooks(
				$integrations->get_by_identifier( Comment_Form_Integration::IDENTIFIER )
			)
		);

		require __DIR__ . '/../controllers/class-integration-controller.php';

		add_action(
			'unofficial_convertkit_settings_tab_integrations',
			array( new Integration_Controller( $integrations, $this->integration_settings_pages ), 'index' )
		);

		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_integration_tab' ) );
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

			$this->integration_settings_pages[ $integration->get_identifier() ] = $page;
		};

		foreach ( $this->integration_repository->get_all() as $integration ) {

			$id = $integration->get_description();

			if ( ! has_action( 'unofficial_convertkit_admin_integrations_' . $id ) ) {
				continue;
			}

			/**
			 * Add the integration settings page
			 *
			 * @param callable $add_submenu_page
			 * @param Integration $integration The integration which belongs to the identifier
			 */
			do_action(
				'unofficial_convertkit_admin_integrations_' . $id,
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
