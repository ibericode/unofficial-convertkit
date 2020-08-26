<?php

namespace UnofficialConvertKit\Debug;

use UnofficialConvertKit\Debug\Admin\Debug_Hooks as Admin_Debug_Hooks;

class Debug_Hooks {

	/**
	 * Hooks.
	 */
	public function hook() {
		if ( is_admin() ) {
			require __DIR__ . '/../admin/hooks/class-debug-hooks.php';
			( new Admin_Debug_Hooks() )->hook();
		}

		add_action( 'shutdown', array( $this, 'handle_log' ) );
	}

	/**
	 * Write all the logs
	 */
	public function handle_log() {
		$logger = new Logger();

		/**
		 * @see Logger::log()
		 */
		do_action( 'unofficial_convertkit_debug_log', array( $logger, 'log' ) );

		remove_action( 'shutdown', array( $this, 'handle_log' ) );
	}
}
