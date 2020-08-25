<?php

namespace UnofficialConvertKit\Debug\Admin;


use UnofficialConvertKit\Debug\Log_File;

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

		require __DIR__ . '/../../class-log-file.php';
		$file = new Log_File();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/debug/admin/view-tab.php';

		$file->rewind();
		$view( $file );
	}
}
