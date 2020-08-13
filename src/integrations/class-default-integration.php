<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Integrations\Admin\Default_Integration_Hooks;

/**
 * Extends this class if the integration uses the default options.
 * Class Default_Integration
 *
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
	protected $options = array();

	/**
	 * @var bool
	 */
	private $is_active;

	/**
	 * @var bool
	 */
	protected $uses_enabled = true;

	public function __construct() {
		if ( ! $this->uses_enabled ) {
			unset( $this->default_options['enabled'] );
		}

		$this->options   = $this->build_options();
		$this->is_active = $this->build_is_active();
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
		return $this->is_available() && $this->is_active;
	}

	/**
	 * Build the options. When the option is empty the default option is returned e.g. merged.
	 *
	 * @return array
	 */
	private function build_options(): array {
		$options = get_option( 'unofficial_convertkit_integrations' );

		if ( empty( $options[ $this->get_identifier() ] ) ) {
			$this->default_options['checkbox-label'] = __( 'Subscribe me to the newsletter', 'unofficial-convertkit' );
			return $this->default_options;
		}

		return array_merge( $this->default_options, $this->add_options(), $options[ $this->get_identifier() ] );
	}

	/**
	 * Whe assume when the form_ids are not empty that the integration is active.
	 *
	 * @return bool
	 */
	private function build_is_active(): bool {
		return ( ! $this->uses_enabled || ( $this->uses_enabled && $this->options['enabled'] ) ) && ! empty( $this->options['form-ids'] );
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

	/**
	 * Is called when when the `is_admin` function return true. And calls the hook function.
	 *
	 * @return Default_Integration_Hooks
	 *
	 * @see is_admin()
	 */
	public function admin_hooks(): Default_Integration_Hooks {
		return new Default_Integration_Hooks( $this );
	}
}
