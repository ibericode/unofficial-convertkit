<?php

namespace UnofficialConvertKit\Integrations;

/**
 * The default `Default_Integration_Hooks::hook` method is only called when the integration is active and available
 *
 * Class Default_Integration_Hooks
 * @package UnofficialConvertKit\Integrations
 */
abstract class Integration_Hooks {

	/**
	 * @var Default_Integration
	 */
	protected $integration;

	/**
	 * @var array html label attributes for the checkbox
	 */
	protected $attributes = array();

	/**
	 * @var string
	 */
	protected $tag = 'p';

	public function __construct( Default_Integration $integration ) {
		$this->integration = $integration;
	}

	public function hook() {
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

		$checkbox( $checkbox_label, $this->tag, $this->attributes );
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
		$checkbox = $_POST['unofficial_convertkit_integrations_subscribe'] ?? '';

		if ( ! empty( $checkbox ) && '1' === $checkbox ) {
			return $parameters;
		}

		return null;
	}
}
