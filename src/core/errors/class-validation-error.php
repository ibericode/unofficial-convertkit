<?php

namespace UnofficialConvertKit;

use InvalidArgumentException;
use RuntimeException;

/**
 * Validation errors are not thrown but
 */
class Validation_Error extends RuntimeException {

	/**
	 * @var string[] The allowed notices
	 */
	private static $types = array( 'error', 'warning' );

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $key;

	/**
	 * Validation_Error constructor.
	 *
	 * @param string $message
	 * @param string $key
	 * @param string $type
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices#Example
	 */
	public function __construct( $message, string $key, string $type = 'error' ) {
		if ( ! in_array( $type, static::$types ) ) { //phpcs:disable
			throw new InvalidArgumentException(
				sprintf( '%s doesn\'t match the allowed types %s', $type, join( ' ', static::$types ) )
			);
		}

		parent::__construct( $message );

		$this->type = $type;
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getKey(): string {
		return $this->key;
	}
}
