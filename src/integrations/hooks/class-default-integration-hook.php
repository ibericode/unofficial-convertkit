<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooks;

//ToDo: how to generalize all the boiler plate code.
abstract class Default_Integration_Hooks implements Hooks {

	/**
	 * @var Default_Integration
	 */
	protected $integration;

	/**
	 * @var array html label attributes for the checkbox
	 */
	protected $attributes = array();

	public function __construct( Default_Integration $integration ) {
		$this->integration = $integration;
	}

	/**
	 * Output the checkbox
	 *
	 * @param array $attributes html label attributes for the checkbox
	 */
	final protected function display_checkbox( array $attributes = array() ) {
		$attributes = array_merge( $this->attributes, $attributes );

		$checkbox_label = $this->integration->get_options()['checkbox-label'];
		$checkbox       = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/default-integration-select-box.php';

		$checkbox( $checkbox_label, $attributes );
	}

	/**
	 * Return the checkbox with usage of output buffering.
	 *
	 * @param array $attributes html label attributes for the checkbox
	 *
	 * @return string the html checkbox
	 */
	final protected function get_html_checkbox( array $attributes = array() ): string {
		ob_start();

		$this->display_checkbox( $attributes );

		return ob_get_clean();
	}
}
