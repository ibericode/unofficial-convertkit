<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Settings_Hooks;

class Integrations_Hooks implements Hooks {

	/**
	 * @var string[] menu slugs
	 */
	private $integrations = array(
		'unofficial-convertkit-custom-integration',
	);

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		add_filter( 'parent_file', array( $this, 'highlight_sub_menu' ) );
		add_action( 'admin_menu', array( $this, 'add_integrations_settings_pages' ) );

		require __DIR__ . '/class-custom-hooks.php';
		$hooker->add_hook( new Custom_Hooks() );
	}

	/**
	 * Load the integrations settings pages
	 */
	public function add_integrations_settings_pages() {
		foreach ( $this->integrations as $integration ) {
			add_submenu_page(
				null,
				__( 'Integration', 'unofficial-convertkit' ),
				null,
				'manage_options',
				$integration,
				'__return_null'
			);
		}
	}


	/**
	 * Highlight the unofficial ConvertKit in the sub menu when you are at a integration page.
	 *
	 * @param string $slug
	 *
	 * @return string
	 */
	public function highlight_sub_menu( string $slug ): string {
		global $submenu_file, $plugin_page;

		if ( in_array( $_GET['page'] ?? '', $this->integrations, true ) ) {
			$submenu_file = Settings_Hooks::MENU_SLUG;
			$plugin_page  = Settings_Hooks::MENU_SLUG;
		}

		return $slug;
	}
}
