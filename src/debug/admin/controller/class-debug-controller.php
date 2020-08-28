<?php

namespace UnofficialConvertKit\Debug\Admin;

use UnofficialConvertKit\Debug\Log_Reader;
use UnofficialConvertKit\Debug\Logger;

class Debug_Controller {

	/**
	 * @var string
	 */
	private $log_file;

	public function __construct() {
		$this->log_file = Logger::get_log_file_path();
	}

	/**
	 * The index of the tab.
	 */
	public function index() {
		require __DIR__ . '/../../class-log-reader.php';
		$log_reader = new Log_Reader( $this->log_file );
		$view       = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/debug/admin/view-tab.php';

		$view( $log_reader );
	}

	/**
	 * Remove the log.
	 */
	public function remove_log() {
		wp_delete_file( $this->log_file );

		wp_redirect(
			admin_url( 'options-general.php?page=unofficial_convertkit&tab=debug' )
		);

		exit;
	}
}
