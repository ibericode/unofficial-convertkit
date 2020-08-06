<?php

namespace UnofficialConvertKit\Integrations;

class Registration_Form_Hooks extends Integration_Hooks {

	public function hook() {
		parent::hook();

		$callable = array( $this, 'display_checkbox' );

		add_action( 'um_after_register_fields', $callable, 20, 0 );
		add_action( 'register_form', $callable, 20, 0 );
		add_action( 'woocommerce_register_form', $callable, 20, 0 );
	}
}
