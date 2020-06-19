<?php

namespace UnofficialConvertKit;

interface Validator_Interface {

	/**
	 * Validate the data
	 *
	 * @param mixed $data the data to validate
	 *
	 * @return Validation_Error[]
	 */
	public function validate( $data ): array;


	/**
	 * Notice the user
	 *
	 * @param Validation_Error $error
	 *
	 * @return void
	 */
	public function notice( Validation_Error $error);
}
