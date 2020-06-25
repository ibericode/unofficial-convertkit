<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integration\Comment_Form_Integration;

class Comment_Form_Hooks implements Hooks {

	const MENU_SLUG = 'unofficial-convertkit-comment-form-integration';

	/**
	 * @var Comment_Form_Integration
	 */
	private $integration;

	public function __construct( Comment_Form_Integration $integration ) {
		$this->integration = $integration;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		//ToDo: create abstract class fot the basic stuff
		require __DIR__ . '/../controllers/class-comment-form-controller.php';
		$controller = new Comment_Form_Controller( $this->integration );

		$id = $this->integration->get_identifier();

		add_filter(
			'unofficial_convertkit_integrations_admin_menu_slug_' . $id,
			array( $this, 'get_settings_page_slug' )
		);

		add_action(
			'unofficial_convertkit_integrations_admin_' . $id,
			array( $this, 'add_settings_page' )
		);

		add_action(
			'admin_page_unofficial-convertkit-comment-form-integration',
			array( $controller, 'index' )
		);

		add_action(
			'sanitize_option_unofficial_convertkit_integration_comment_form',
			array( $controller, 'save' )
		);

		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register the settings
	 *
	 * @ignore
	 * @internal
	 */
	public function register_settings() {
		\register_setting(
			'unofficial_convertkit_integration',
			'unofficial_convertkit_integration_comment_form'
		);
	}

	/**
	 * Get the menu slug of the settings pages
	 *
	 * @ignore
	 * @internal
	 */
	public function get_settings_page_slug() {
		return self::MENU_SLUG;
	}

	/**
	 * Add the settings page.
	 *
	 * @param callable $add_submenu_page
	 *
	 * @ignore
	 * @internal
	 */
	public function add_settings_page( callable $add_submenu_page ) {
		$add_submenu_page( self::MENU_SLUG, $this->integration );
	}
}
