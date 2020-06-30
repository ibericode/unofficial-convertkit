<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;
use UnofficialConvertKit\Integrations\Integration;

class Contact_Form_7_Hooks extends Integration_Hooks {

	public function __construct() {
		parent::__construct( Contact_Form_7_Integration::IDENTIFIER );
	}

	public function hook( Hooker $hooker ) {
		add_filter( 'unofficial_convertkit_integrations_show_enabled', array( $this, 'show_enabled' ), 10, 2 );

		parent::hook( $hooker );
	}

	public function show_enabled( bool $bool, Integration $integration ) {
		return $integration->get_identifier() !== Contact_Form_7_Integration::IDENTIFIER;
	}

	/**
	 * @inheritDoc
	 */
	function sanitize_options( array $settings, Integration $integration ): array {
		//ToDo: implement method()
		return array();
	}
}
