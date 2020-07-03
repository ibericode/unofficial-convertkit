<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;

class Woo_Commerce_Hooks extends Default_Integration_Hooks {


	protected $attributes = array( 'class' => 'form-row form-row-wide' );

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'woocommerce_form_field_email', array( $this, 'show_checkbox' ), 22, 2 );
	}

	/**
	 * Add the checkbox to the comment form.
	 *
	 * @param mixed $field
	 * @param mixed $key
	 *
	 * @return string
	 *
	 * @internal
	 * @ignore
	 */
	public function show_checkbox( $field, $key ): string {
		if ( 'billing_email' !== $key ) {
			return $field;
		}

		$field .= PHP_EOL;
		$field .= $this->get_html_checkbox();

		return $field;

	}
}
