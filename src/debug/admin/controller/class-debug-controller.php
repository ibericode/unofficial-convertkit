<?php

namespace UnofficialConvertKit\Debug\Admin;

use UnofficialConvertKit\Debug\Log_Reader;
use UnofficialConvertKit\Debug\Logger;

use function UnofficialConvertKit\Debug\debug;

class Debug_Controller {

	/**
	 * The index of the tab.
	 */
	public function index() {
		$log_file = Logger::get_log_file_path();

		if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
			wp_delete_file( $log_file );

			wp_redirect(
				admin_url( 'options-general.php?page=unofficial_convertkit&tab=debug' )
			);

			exit;
		}

		require __DIR__ . '/../../class-log-reader.php';
		$log_reader = new Log_Reader( $log_file );
		$view       = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/debug/admin/view-tab.php';

		$view( $log_reader );
	}
}
