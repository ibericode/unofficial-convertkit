<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Custom_Hooks implements Hooks {

	const MENU_SLUG = 'unofficial-convertkit-custom-integration';

	public function hook( Hooker $hooker ) {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/integrations/controllers/class-custom-controller.php';
		add_action( 'admin_page_unofficial-convertkit-custom-integration', array( new Custom_Controller(), 'index' ) );
	}
}
