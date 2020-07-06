<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\get_option;

final class Default_Integrations_Hooks implements Hooks {

	/**
	 * @var Default_Integration[]
	 */
	private $default_integrations = array();

	/**
	 * General action specific for default_integrations which must be always be applied
	 *
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'unofficial_convertkit_integration_added', array( $this, 'push' ) );

		add_action( 'delete_option_unofficial_convertkit_settings', array( $this, 'prune' ) );
		add_action( 'update_option_unofficial_convertkit_settings', array( $this, 'prune' ) );
	}


	/**
	 * Keep track of the default integrations.
	 *
	 * @param Integration $integration
	 */
	public function push( Integration $integration ) {
		if ( ! $integration instanceof Default_Integration ) {
			return;
		}

		$this->default_integrations[] = $integration;
	}

	/**
	 * Prune the options state
	 *
	 * @param mixed $old_value
	 */
	public function prune( $old_value = null ) {
		$option = \get_option( Integrations_Hooks::OPTION_NAME );

		if ( 'unofficial_convertkit_settings' !== $old_value ) {
			$api_secret = $old_value['api_secret'] ?? '';
			$api_key    = $old_value['api_key'] ?? '';

			if ( get_option( 'api_secret' ) === $api_secret || get_option( 'api_key' ) === $api_key ) {
				return;
			}
		}

		foreach ( $this->default_integrations as $integration ) {
			$option[ $integration->get_identifier() ] = $integration->prune();
		}

		update_option( Integrations_Hooks::OPTION_NAME, $option );
	}

}
