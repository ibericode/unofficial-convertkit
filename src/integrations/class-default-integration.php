<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooks;

/**
 * Extends this class if the integration uses the default options.
 * Class Default_Integration
 * @package UnofficialConvertKit\Integrations
 *
 * @see Default_Integration::$default_options the default options per integration
 */
abstract class Default_Integration implements Integration {

	protected $default_options = array(
		'enabled'        => false,
		'form-ids'       => array(),
		'checkbox-label' => '',
	);

	/**
	 * @var array
	 */
	protected $options;

	/**
	 * @var bool
	 */
	protected $uses_enabled = true;

	public function __construct() {
		if ( ! $this->uses_enabled ) {
			unset( $this->default_options['enabled'] );
		}

		$this->options = $this->build_options();

	}

	/**
	 * @inheritDoc
	 */
	public function get_options(): array {
		return $this->options;
	}

	/**
	 * @inheritDoc
	 */
	public function is_active(): bool {
		return $this->options['enabled'];
	}

	/**
	 * Build the options. When the option is empty the default option is returned
	 *
	 * @return array
	 */
	private function build_options(): array {
		$options = get_option( Integrations_Hooks::OPTION_NAME );

		if ( empty( $options[ $this->get_identifier() ] ) ) {
			return $this->default_options;
		}

		return array_merge( $this->default_options, $this->add_options(), $options[ $this->get_identifier() ] );
	}

	/**
	 * @return bool true when the integration enable/disable button's are enabled in the form, otherwise false
	 */
	public function get_uses_enabled(): bool {
		return $this->uses_enabled;
	}

	/**
	 * Override this method if the integrations has additional options.
	 *
	 * @return array the extra options the provided value is used has fallback/default value
	 */
	protected function add_options(): array {
		return array();
	}
}
