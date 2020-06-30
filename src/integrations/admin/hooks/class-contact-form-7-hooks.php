<?php


namespace UnofficialConvertKit\Integrations\Admin;


use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;
use UnofficialConvertKit\Integrations\Integration;

class Contact_Form_7_Hooks extends Integration_Hooks {

	public function __construct() {
		parent::__construct( Contact_Form_7_Integration::IDENTIFIER );
	}

	/**
	 * @inheritDoc
	 */
	function sanitize_options( array $settings, Integration $integration ): array {
		//ToDo: implement method()
		return array();
	}
}
