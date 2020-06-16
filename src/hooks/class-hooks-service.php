<?php

namespace UnofficialConvertKit;

use LogicException;

class Hooks_Service implements Hooks {

	private $called = false;

	/**
	 * @var Hooks
	 */
	private $hooks;

	/**
	 * @param Hooks $hooks
	 */
	public function add_hook( Hooks $hooks ) {
		$this->hooks[] = $hooks;
	}

	/**
	 * Call the hook method of the hooks.
	 */
	public function hook() {

		if ( $this->called ) {
			throw new LogicException(
				sprintf( '%s can not be called two times.', __FUNCTION__ )
			);
		}

		foreach ( $this->hooks as $hook ) {
			$hook->hook();
		}

		$this->called = true;
	}
}
