<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

/**
 * The default `Default_Integration_Hooks::hook` method is only called when the integration is active and available
 *
 * Class Default_Integration_Hooks
 * @package UnofficialConvertKit\Integrations
 */
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
	 * @param Hooker $hooker
	 */
	public function hook( Hooker $hooker ) {
		add_filter(
			'unofficial_convertkit_integrations_parameters_' . $this->integration->get_identifier(),
			array( $this, 'default_integration_checkbox_checked' ),
			10,
			1
		);
	}

	/**
	 * Output the checkbox
	 */
	final public function display_checkbox() {
		$checkbox_label = $this->integration->get_options()['checkbox-label'];
		$checkbox       = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/default-integration-checkbox.php';

		$checkbox( $checkbox_label, $this->attributes );
	}

	/**
	 * Return the checkbox with usage of output buffering.
	 *
	 * @return string the html checkbox
	 */
	final public function get_html_checkbox(): string {
		ob_start();

		$this->display_checkbox();

		return ob_get_clean();
	}

	/**
	 * Only send the request if the checkbox is present in the request.
	 *
	 * @param array|null $parameters
	 *
	 * @return array|null
	 */
	public function default_integration_checkbox_checked( $parameters ) {
		if ( isset( $_REQUEST['unofficial_convertkit_integrations_subscribe'] ) ) {
			return $parameters;
		}

		return null;
	}
}
