<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Integrations\Integration;
use UnofficialConvertKit\Integrations\Woo_Commerce_Integration;

class Woo_Commerce_Hooks extends Integration_Hooks {

	public function __construct() {
		parent::__construct( Woo_Commerce_Integration::IDENTIFIER );
	}

	/**
	 * @inheritDoc
	 */
	function sanitize_options( array $settings, Integration $integration ): array {
		// TODO: Implement sanitize_options() method.
		return array();
	}
}
