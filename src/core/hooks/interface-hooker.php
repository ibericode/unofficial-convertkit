<?php

namespace UnofficialConvertKit;

interface Hooker {

	/**
	 * Add a hook to the hooks which must be hooked in order to get registered in WordPress.
	 *
	 * @param Hooks $hook
	 *
	 * @param mixed|null $data Data to attach to hooker
	 *
	 * @return void
	 */
	public function add_hook( Hooks $hook, $data = null );


	/**
	 * Get the data of the current hooker in memory.
	 *
	 * @return mixed|null Null when no data is attached otherwise the value attached
	 */
	public function get_data();
}
