<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;

class Registration_Form_Hooks extends Default_Integration_Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		parent::hook( $hooker );

		$callable = array( $this, 'display_checkbox' );

		add_action( 'um_after_register_fields', $callable, 20, 0 );
		add_action( 'register_form', $callable, 20, 0 );
		add_action( 'woocommerce_register_form', $callable, 20, 0 );
	}
}
