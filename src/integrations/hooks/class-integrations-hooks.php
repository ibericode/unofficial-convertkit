<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Settings\Settings_Hooks;

class Integrations_Hooks implements Hooks {

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	public function __construct() {
		//Register the predefined integrations.
		$this->integration_repository = new Integration_Repository(
			array(
				new Comment_Form_Integration(),
			)
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		if ( ! is_admin() ) {
			return;
		}

		//admin hooks
		add_filter( 'parent_file', array( $this, 'highlight_sub_menu' ) );
		add_action( 'admin_menu', array( $this, 'add_integrations_settings_pages' ) );

		require __DIR__ . '/class-comment-form-hooks.php';
		$hooker->add_hook( new Comment_Form_Hooks() );

		require __DIR__ . '/../controllers/class-integration-controller.php';
		add_action( 'unofficial_convertkit_settings_tab_integrations', array( new Integration_Controller( $this->integration_repository ), 'index' ) );
		add_action( 'unofficial_convertkit_settings_tab', array( $this, 'settings_integration_tab' ) );
	}

	/**
	 * @param callable $render_tab
	 */
	public function settings_integration_tab( callable $render_tab ) {
		$render_tab( __( 'Integrations', 'unofficial-converkit' ), 'integrations' );
	}

	/**
	 * Load the integrations settings pages
	 *
	 * @internal
	 */
	public function add_integrations_settings_pages() {
		foreach ( $this->integration_repository->get_all() as $integration ) {
			add_submenu_page(
				null,
				$integration->get_name(),
				null,
				'manage_options',
				$integration->get_identifier(),
				function () use ( $integration ) {
					do_action( 'unofficial_convertkit_integration_page_' . $integration->get_identifier(), $integration );
				}
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
	 * @internal
	 */
	public function highlight_sub_menu( string $slug ): string {
		$identifiers = array_map(
			function( Integration $integration ) {
				return $integration->get_identifier();
			},
			$this->integration_repository->get_all()
		);

		if ( in_array( $_GET['page'] ?? '', $identifiers, true ) ) {
			global $submenu_file, $plugin_page;

			$submenu_file = Settings_Hooks::MENU_SLUG;
			$plugin_page  = Settings_Hooks::MENU_SLUG;
		}

		return $slug;
	}

	/**
	 * @internal
	 */
	public function register_custom_integrations() {
		if ( ! has_action( 'unofficial_convertkit_add_integrations' ) ) {
			return;
		}

		/**
		 * Register your integration.
		 * Create a class which implements the Integration interface and pass the instance to callable.
		 *
		 * @param callable takes instance of the Integration interface as first argument
		 *
		 * @return void
		 *
		 * @see Integration_Repository::add_integration()
		 * @see Integration
		 */
		do_action( 'unofficial_convertkit_add_integrations', array( $this->integration_repository, 'add_integration' ) );
	}
}
