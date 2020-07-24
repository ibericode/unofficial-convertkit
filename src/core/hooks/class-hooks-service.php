<?php

namespace UnofficialConvertKit;

use LogicException;
use SplObjectStorage;

class Hooks_Service implements Hooker, Hooks {

	private $called = false;

	/**
	 * @var SplObjectStorage
	 */
	private $object_storage;

	/**
	 * @var mixed|null
	 */
	private $data;

	public function __construct() {
		$this->object_storage = new SplObjectStorage();
	}

	/**
	 * {@inheritDoc}
	 */
	public function add_hook( Hooks $hooks, $data = null ) {
		$this->object_storage->attach( $hooks, $data );
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_data() {
		return $this->data;
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

		$storage = $this->object_storage;

		do_action( 'unofficial_convertkit_hook', $hooker );

		while ( $storage->valid() ) {
			$hook = $storage->current();

			$this->data = $storage->getInfo();

			$hook->hook( $hooker );

			$this->data = null;
			$storage->next();
		}

		/**
		 * Fires after the unofficial ConvertKit is bootstrapped.
		 */
		do_action( 'unofficial_convertkit_bootstrapped' );

		$this->called = true;
	}
}
