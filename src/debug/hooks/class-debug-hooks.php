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
	}
}
