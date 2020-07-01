<?php

namespace UnofficialConvertKit\Integrations;

/**
 * Extends this class if the integration uses the default options.
 *
 * Class Default_Integration
 * @package UnofficialConvertKit\Integrations
 */
abstract class Default_Integration implements Integration {

	protected static $default_options = array(
		'enabled'        => false,
		'form-ids'       => array(),
		'checkbox-label' => '',
	);

	/**
	 * @var array
	 */
	protected $options;

	public function __construct( bool $uses_enabled = true ) {
		if ( ! $uses_enabled ) {
			unset( static::$default_options['enabled'] );
		}

		$this->options = $this->build_options();
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
			return static::$default_options;
		}

		return array_merge( static::$default_options, $options[ $this->get_identifier() ] );
	}
}
