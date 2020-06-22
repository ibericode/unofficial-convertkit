<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integration\Comment_Form_Integration;

class Comment_Form_Hooks implements Hooks {


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
		require __DIR__ . '/../controllers/class-comment-form-controller.php';
		$controller = new Comment_Form_Controller( $this->integration );

		add_action( 'unofficial_convertkit_admin_integrations_' . $this->integration->get_identifier(), array( $this, 'add_settings_page' ) );

		add_action(
			'admin_page_unofficial-convertkit-comment-form-integration',
			array( $controller, 'index' )
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
		\register_setting( $this->integration->get_identifier(), 'unofficial_convertkit' );
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
		$add_submenu_page( 'unofficial-convertkit-comment-form-integration', $this->integration );
	}
}
