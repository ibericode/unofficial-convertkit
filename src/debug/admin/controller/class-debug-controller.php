<?php

namespace UnofficialConvertKit\Debug\Admin;

use UnofficialConvertKit\Debug\Log_File;
use UnofficialConvertKit\Debug\Logger;

class Debug_Controller {

	/**
	 *
	 */
	public function index() {
		if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			wp_delete_file( Logger::get_log_file_path() );

			wp_redirect(
				admin_url( 'options-general.php?page=unofficial_convertkit&tab=debug' )
			);

			exit;
		}

		require __DIR__ . '/../../class-log-file.php';
		$file = new Log_File();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/debug/admin/view-tab.php';

		$file->rewind();
		$view( $file );
	}
}
