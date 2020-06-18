<?php

namespace UnofficialConvertKit;

use LogicException;

class Hooks_Service implements Hooker, Hooks {

	private $called = false;

	/**
	 * @var Hooks[]
	 */
	private $hooks;

	/**
	 * {@inheritDoc}
	 */
	public function add_hook( Hooks $hooks ) {
		$this->hooks[] = $hooks;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {

		if ( $this->called ) {
			throw new LogicException(
				sprintf( '%s can not be called two times.', __FUNCTION__ )
			);
		}

		foreach ( $this->hooks as $index => $hook ) {
			$hook->hook( $hooker );

			unset( $this->hooks[ $index ] );
		}

		if ( count( $this->hooks ) > 0 ) {
			$this->hook( $hooker );

			return;
		}

		$this->called = true;
	}
}
