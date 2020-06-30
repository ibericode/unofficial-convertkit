<?php

namespace UnofficialConvertKit\Integrations\Admin;


use UnofficialConvertKit\Integrations\Integration;
use UnofficialConvertKit\Integrations\Registration_Form_Integration;

class Registration_Form_Hooks extends Integration_Hooks {

	public function __construct() {
		parent::__construct( Registration_Form_Integration::IDENTIFIER );
	}

	/**
	 * @inheritDoc
	 */
	function sanitize_options( array $settings, Integration $integration ): array {
		// TODO: Implement sanitize_options() method.
	}
}
