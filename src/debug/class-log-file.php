<?php

namespace UnofficialConvertKit\Debug;

use Exception;
use Iterator;

final class Log_File implements Iterator {

	/**
	 * @var int
	 */
	private $line = 0;

	/**
	 * @var null|resource
	 */
	private $resource;

	/**
	 * @return Log|null
	 */
	public function current() {
		if ( ! $this->init() ) {
			return null;
		}

		try {
			return Log::from_format(
				fgets( $this->resource )
			);
		} catch ( Exception $e ) {
			return null;
		}
	}

	public function next() {
		++$this->line;
	}

	/**
	 * @return int|false
	 */
	public function key() {
		return $this->line;
	}

	/**
	 * @return bool
	 */
	public function valid(): bool {
		return ! feof( $this->resource );
	}

	/**
	 * Reset to first line
	 */
	public function rewind() {
		if ( ! $this->init() ) {
			return;
		}

		$this->line = 0;
		rewind( $this->resource );
	}

	/**
	 * @return false
	 */
	private function init(): bool {
		if ( is_null( $this->resource ) ) {
			$this->resource = @fopen( Logger::get_log_file_path(), 'cb+' );
		}

		if ( false === $this->resource ) {
			return false;
		}

		if ( $this->key() === 0 && fgets( $this->resource ) === Logger::EXIT_CODE ) {
			$this->next();
		}

		return true;
	}

	/**
	 * Close the resource.
	 */
	public function __destruct() {
		fclose( $this->resource );
	}
}
