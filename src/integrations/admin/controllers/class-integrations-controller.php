<?php

namespace UnofficialConvertKit\Integrations\Admin;

use DomainException;
use UnofficialConvertKit\Integrations\Integration;
use UnofficialConvertKit\Integrations\Integration_Repository;
use UnofficialConvertKit\Integrations\Integrations_Hooks as General_Integrations_Hooks;
use function UnofficialConvertKit\get_rest_api;

/**
 * Controller for integrations settings.
 */
class Integrations_Controller {

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	public function __construct(
		Integration_Repository $integration_repository
	) {
		$this->integration_repository = $integration_repository;
	}

	/**
	 * Show all the registered integrations to the admin.
	 */
	public function index() {
		$integrations = $this->integration_repository->get_all();

		$active        = array_filter(
			$integrations,
			function( $i ) {
				return $i->is_active();
			}
		);
		$available     = array_filter(
			$integrations,
			function( $i ) {
				return ! $i->is_active() && $i->is_available();
			}
		);
		$not_installed = array_filter(
			$integrations,
			function( $i ) {
				return ! $i->is_available();
			}
		);
		$sorter        = function( Integration $a, Integration $b ) {
			return strcmp( $a->get_name(), $b->get_name() );
		};
		usort( $active, $sorter );
		usort( $available, $sorter );
		usort( $not_installed, $sorter );
		$integrations = array_merge( $active, $available, $not_installed );

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-integrations-page.php';
		$view( $integrations );
	}

	/**
	 * Show the admin form of the integration.
	 */
	public function show() {
		try {
			$integration = $this->integration_repository->get_by_identifier( $_GET['id'] );
		} catch ( DomainException $d ) {
			wp_die( sprintf( 'No such integration: %s', $_GET['id'] ) );
		}

		$id = $integration->get_identifier();

		if ( has_action( 'unofficial_convertkit_integrations_integration_setting_template_' . $id ) ) {
			/**
			 * @param null|callable inherit from callable like a block
			 * @param Integration $integration the integration of the page.
			 *
			 * @return callable the callable outputs
			 */
			do_action(
				'unofficial_convertkit_integrations_integration_setting_template_' . $id,
				$integration
			);

			return;
		}

		$forms    = get_rest_api()->list_forms();
		$template = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-default-integration-option-page.php';

		$template( $integration, $forms );
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 * @see Integration::get_identifier()
	 */
	public function save( array $settings ): array {
		remove_filter( 'sanitize_option_unofficial_convertkit_integrations', array( $this, 'save' ) );

		$options = get_option( General_Integrations_Hooks::OPTION_NAME );

		$id = $settings['id'] ?? '';

		//Id does not exists.
		if ( ! array_key_exists( $id, $settings ) || ! $this->integration_repository->exists( $id ) ) {
			return $options;
		}

		$integration = $this->integration_repository->get_by_identifier( $id );

		/**
		 * Validate and sanitize your options/settings.
		 *
		 * @param mixed $settings
		 *
		 * @return mixed
		 */
		$integration_option = apply_filters( 'unofficial_convertkit_integrations_admin_sanitize_' . $id, $settings[ $id ], $integration );

		$option = $options[ $id ] ?? array();
		//Only add the option if not equal
		if ( $option !== $integration_option ) {
			$options[ $id ] = $integration_option;
		}

		return $options;
	}
}
