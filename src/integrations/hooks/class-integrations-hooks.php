<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\API\V3\Response_Exception;
use UnofficialConvertKit\Integrations\Admin\Integrations_Hooks as Admin_Integrations_Hooks;

use function UnofficialConvertKit\Debug\log_error;
use function UnofficialConvertKit\Debug\log_warning;
use function UnofficialConvertKit\get_rest_api;

class Integrations_Hooks {

	const OPTION_NAME = 'unofficial_convertkit_integrations';

	/**
	 * @var Integration_Repository
	 */
	protected $integrations;

	public function __construct() {
		$this->integrations = new Integration_Repository();
	}

	public function hook() {
		if ( is_admin() ) {
			require __DIR__ . '/../admin/hooks/class-integrations-hooks.php';
			( new Admin_Integrations_Hooks( $this->integrations ) )->hook();
		}

		add_action( 'plugins_loaded', array( $this, 'load_integrations' ), 11 );
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
			log_warning(
				sprintf( '%s > no forms are selected', $integration->get_name() )
			);
			return;
		}

		foreach ( $form_ids as $form_id ) {
			try {
				get_rest_api()->add_form_subscriber(
					$form_id,
					$parameters
				);
			} catch ( Response_Exception $e ) {
				// Silence this error because we do not want to break the form we are integrating with
				log_error( $e->getMessage() );
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
		$this->integrations->add(
			new Comment_Form_Integration(),
			new Registration_Form_Integration(),
			new Contact_Form_7_Integration()
		);

		/**
		 * Register your integration.
		 * Create a class which implements the Integration interface and pass the instance to callable.
		 *
		 * @param callable takes instance of the Integration interface as first argument
		 *
		 * @return void
		 *
		 * @see Integration_Repository::add()
		 * @see Integration
		 */
		do_action( 'unofficial_convertkit_add_integration', array( $this->integrations, 'add' ) );
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
