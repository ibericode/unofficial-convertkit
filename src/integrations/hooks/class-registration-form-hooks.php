<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Registration_Form_Hooks implements Hooks {


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

		$callable = array( $this, 'show_checkbox' );

		add_action( 'um_after_register_fields', $callable, 20 );
		add_action( 'register_form', $callable, 20 );
		add_action( 'woocommerce_register_form', $callable, 20 );
	}

	/**
	 * Show the checkbox
	 *
	 * @internal
	 * @ignore
	 */
	public function show_checkbox() {
		$checkbox_label = $this->integration->get_options()['checkbox-label'];

		$checkbox = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/default-integration-select-box.php';

		$checkbox( $checkbox_label );
	}
}
