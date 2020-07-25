<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\API\V3\Response_Exception;
use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Admin\Integrations_Hooks as Admin_Integrations_Hooks;
use function UnofficialConvertKit\get_rest_api;

class Integrations_Hooks implements Hooks {

	const OPTION_NAME = 'unofficial_convertkit_integrations';

	/**
	 * @var Integration_Repository
	 */
	protected $integrations;

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		//Todo: only add the hooks when needed.
		$this->integrations = new Integration_Repository( $hooker );

		if ( is_admin() ) {
			require __DIR__ . '/../admin/hooks/class-integrations-hooks.php';
			$hooker->add_hook( new Admin_Integrations_Hooks( $this->integrations ) );
		}

		add_action( 'init', array( $this, 'load_integrations' ) );

		add_action( 'unofficial_convertkit_integrations_notice', array( $this, 'send_integration_to_convertkit' ), 10, 2 );
		add_filter( 'default_option_unofficial_convertkit_integrations', array( $this, 'set_default_option' ) );
	}

	/**
	 * @param array $parameters
	 * @param Integration $integration
	 */
	public function send_integration_to_convertkit( array $parameters, Integration $integration ) {
		$options = $integration->get_options();

		/**
		 * Filter the form ids for ConvertKit API.
		 *
		 * @param int[] $form_ids
		 * @param Integration $integration
		 *
		 * @return int[]
		 */
		$form_ids = apply_filters( 'unofficial_convertkit_integrations_requested_form_ids_' . $integration->get_identifier(), $options['form-ids'] ?? array(), $integration );

		if ( empty( $form_ids ) ) {
			return;
		}

		foreach ( $form_ids as $form_id ) {
			try {
				get_rest_api()->add_form_subscriber(
					$form_id,
					$parameters
				);
			} catch ( Response_Exception $e ) {
				//silence
			}
		}
	}

	/**
	 * Load all the integrations.
	 *
	 * @internal
	 * @ignore
	 */
	public function load_integrations() {
		$integrations = $this->integrations;
		$integrations->add_integration( new Comment_Form_Integration() );
		$integrations->add_integration( new Registration_Form_Integration() );
		$integrations->add_integration( new Contact_Form_7_Integration() );

		if ( ! has_action( 'unofficial_convertkit_add_integration' ) ) {
			return;
		}

		/**
		 * Register your integration.
		 * Create a class which implements the Integration interface and pass the instance to callable.
		 *
		 * @param callable takes instance of the Integration interface as first argument
		 *
		 * @return void
		 *
		 * @see Integration_Repository::add_integration()
		 * @see Integration
		 */
		do_action( 'unofficial_convertkit_add_integration', array( $integrations, 'add_integration' ) );
	}

	/**
	 * Set the default options.
	 * The default array is empty.
	 *
	 * @return array
	 */
	public function set_default_option(): array {
		return array();
	}
}
