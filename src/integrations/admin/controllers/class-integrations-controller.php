<?php

namespace UnofficialConvertKit\Integrations\Admin;

use DomainException;
use UnofficialConvertKit\Integrations\Integration;
use UnofficialConvertKit\Integrations\Integration_Repository;
use UnofficialConvertKit\Integrations\Integrations_Hooks as General_Integrations_Hooks;
use function UnofficialConvertKit\get_rest_api;

/**
 * Class Integration_Controller
 * @package UnofficialConvertKit
 *
 * Controller for integrations settings.
 */
class Integration_Controller {

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
		//ToDo: sort integrations add `is_available` and `is_active`
		$integrations = $this->integration_repository->get_all();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-integrations-page.php';
		$view( $integrations );
	}

	/**
	 * Show the admin form of the integration.
	 */
	public function show() {
		try {
			$integration = $this->integration_repository->get_by_identifier( $_GET['id'] ?? '' );
		} catch ( DomainException $d ) {
			//ToDo: think what to do if slug is empty.
			wp_die(
				__( 'Integration identifier not found', 'unofficial-convertkit' ),
				__( 'Not found', 'unofficial-convertkit' ),
				404
			);
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

		$forms    = get_rest_api()->lists_forms();
		$template = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-base-integration-option-page.php';

		$template( $integration, $forms );
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 * @see Integration::get_identifier()
	 */
	public function save( array $settings ): array {
		$options = get_option( General_Integrations_Hooks::OPTION_NAME, array() );

		$id = $settings['id'];

		//Id does not exists.
		if ( ! $this->integration_repository->exists( $id ) ) {
			return $options;
		}

		$integration = $this->integration_repository->get_by_identifier( $id );

		/**
		 * Sanitize your settings for the integrations.
		 *
		 * @param mixed $settings
		 *
		 * @return mixed
		 */
		$integration_option = apply_filters( 'unofficial_convertkit_integrations_admin_sanitize_' . $id, $settings[ $id ], $integration );

		$options[ $id ] = $integration_option;

		return $options;
	}
}
