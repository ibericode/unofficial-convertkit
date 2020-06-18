<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Comment_Form_Hooks implements Hooks {

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		if ( ! is_admin() ) {
			return;
		}

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/integrations/controllers/class-comment-form-controller.php';
		$controller = new Comment_Form_Controller();

		add_action( 'admin_page_unofficial-convertkit-comment-form-integration', array( $controller, 'index' ) );
	}
}