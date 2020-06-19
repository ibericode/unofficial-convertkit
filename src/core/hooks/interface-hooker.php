<?php


namespace UnofficialConvertKit;

interface Hooker {

	/**
	 * Add a hook to the hooks which must be hooked in order to get registered in WordPress.
	 *
	 * @param Hooks $hook
	 *
	 * @return void
	 */
	public function add_hook( Hooks $hook );
}
