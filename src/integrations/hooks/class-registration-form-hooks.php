<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;

class Registration_Form_Hooks extends Default_Integration_Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {

		$callable = array( $this, 'display_checkbox' );

		add_action( 'um_after_register_fields', $callable, 20, 0 );
		add_action( 'register_form', $callable, 20, 0 );
		add_action( 'woocommerce_register_form', $callable, 20, 0 );

		//TODO: Maybe at this one?
		//add_action( 'user_new_form', $callable, 20 );
	}
}
