<?php

namespace UnofficialConvertKit\Integrations;

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
	protected $uses_enabled;

	public function __construct( bool $uses_enabled = true ) {
		if ( ! $uses_enabled ) {
			unset( $this->default_options['enabled'] );
		}

		$this->options      = $this->build_options();
		$this->uses_enabled = $uses_enabled;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_options(): array {
		return $this->options;
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

		return array_merge( $this->default_options, $options[ $this->get_identifier() ] );
	}

	/**
	 * @return bool true when the integration enable/disable button's are enabled in the form, otherwise false
	 */
	public function get_uses_enabled(): bool {
		return $this->uses_enabled;
	}
}
