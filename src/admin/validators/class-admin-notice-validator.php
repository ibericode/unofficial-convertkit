<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Validation_Error;
use UnofficialConvertKit\Validator_Interface;

abstract class Admin_Notice_Validator implements Validator_Interface {

	/**
	 * @var string
	 */
	protected $setting;

	public function __construct( string $setting ) {
		$this->setting = $setting;
	}

	/**
	 * @inheritDoc
	 */
	public function notice( Validation_Error $error ) {
		add_settings_error(
			$this->setting,
			$error->getKey(),
			$error->getMessage(),
			$error->getType()
		);
	}
}
