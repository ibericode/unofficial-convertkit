<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;
use WPCF7_FormTag;

/**
 * @see https://contactform7.com/2015/01/10/adding-a-custom-form-tag/
 */
class Contact_Form_7_Hooks extends Default_Integration_Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
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
