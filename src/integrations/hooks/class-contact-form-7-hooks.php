<?php

namespace UnofficialConvertKit\Integrations;

/**
 * @see https://contactform7.com/2015/01/10/adding-a-custom-form-tag/
 */
class Contact_Form_7_Hooks extends Integration_Hooks {

	public function hook() {
		parent::hook();
		add_action( 'wpcf7_init', array( $this, 'add_form_tag' ) );
	}

	/**
	 * Register the tag type with the handler
	 *
	 * @internal
	 * @ignore
	 */
	public function add_form_tag() {
		wpcf7_add_form_tag(
			Contact_Form_7_Integration::WPCF7_TAG,
			array( $this, 'get_html_checkbox' )
		);
	}
}
