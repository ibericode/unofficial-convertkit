<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Woo_Commerce_Hooks implements Hooks {


	/**
	 * @var Integration
	 */
	private $integration;

	public function __construct( Integration $integration ) {
		$this->integration = $integration;
	}

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'woocommerce_form_field_email', array( $this, 'show_checkbox' ), 22, 4 );
	}

	public function show_checkbox( $field, $key, $args, $value ) {
		if ( 'billing_email' !== $key ) {
			return $field;
		}

		$checkbox_label = $this->integration->get_options()['checkbox-label'];
		ob_start();
		$checkbox = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/default-integration-select-box.php';
		$checkbox( $checkbox_label, array( 'class' => 'form-row form-row-wide' ) );
		$html = ob_get_clean();

		$field .= PHP_EOL;
		$field .= $html;

		return $field;

	}
}
