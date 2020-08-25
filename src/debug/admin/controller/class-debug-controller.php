<?php

namespace UnofficialConvertKit\Debug\Admin;


class Debug_Controller {

	/**
	 *
	 */
	public function index() {
		if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			wp_redirect(
				admin_url( 'options-page.php?page=unofficial-convertkit?tab=debug' )
			);
			exit( 1 );
		}

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/debug/admin/view-tab.php';

		$view();
	}
}
