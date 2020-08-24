<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Admin\Page;
use UnofficialConvertKit\Admin\Tab;
use UnofficialConvertKit\Integrations\Default_Integration;
use UnofficialConvertKit\Integrations\Integration;
use UnofficialConvertKit\Integrations\Integration_Repository;
use UnofficialConvertKit\Integrations\Integrations_Hooks as General_Integrations_Hooks;

use function UnofficialConvertKit\get_rest_api;

/**
 * All the hooks related to the admin interface for the integrations.
 *
 * Class Integrations_Hooks
 * @package UnofficialConvertKit\Integrations\Admin
 */
class Integrations_Hooks {

	/**
	 * @var Integrations_Controller
	 */
	private $integration_controller;

	/**
	 * @var array[]
	 */
	private $breadcrumb;
	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	public function __construct( Integration_Repository $integration_repository ) {
		require __DIR__ . '/../controllers/class-integrations-controller.php';

		$this->integration_repository = $integration_repository;
		$this->integration_controller = new Integrations_Controller( $integration_repository );
		$this->breadcrumb             = array(
			'url'        => admin_url( 'options-general.php?page=unofficial_convertkit&tab=integrations' ),
			'breadcrumb' => __( 'Integrations', 'unofficial-convertkit' ),
		);
	}

	public function hook() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'unofficial_convertkit_admin_register_tab', array( $this, 'register_tab' ) );
		add_action( 'unofficial_convertkit_admin_register_page', array( $this, 'register_page' ) );

		require __DIR__ . '/class-default-integration-hooks.php';
		add_action( 'unofficial_convertkit_integration_added', array( $this, 'load_default_hooks' ) );
	}

	/**
	 * Load the integrations admin pages. Only for the shipped ones.
	 *
	 * @param Integration $integration
	 */
	public function load_default_hooks( Integration $integration ) {
		if ( ! $integration instanceof Default_Integration ) {
			return;
		}

		$integration->admin_hooks()->hook();
	}

	/**
	 * Register the integration
	 *
	 * @ignore
	 * @internal
	 */
	public function register_settings() {
		register_setting(
			General_Integrations_Hooks::OPTION_NAME,
			General_Integrations_Hooks::OPTION_NAME,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this->integration_controller, 'save' ),
			)
		);
	}

	/**
	 * @param callable $register_page
	 *
	 * @internal
	 */
	public function register_page( callable $register_page ) {
		$current_page = null;
		$integrations = $this->integration_repository;
		$breadcrumbs  = array( $this->breadcrumb );

		do_action(
			'unofficial_convertkit_integrations_admin_integration_page',
			static function( Page $page ) use ( &$current_page, $integrations, &$breadcrumbs ) {
				$id = $_GET['id'] ?? null;

				if ( null === $id ) {
					return;
				}

				if ( $page->get_identifier() !== $id ) {
					return;
				}

				if ( ! $integrations->exists( $page->get_identifier() ) ) {
					return;
				}

				$current_page = $page;
				$breadcrumbs  = array_merge( $breadcrumbs, $page->get_breadcrumbs() );
			}
		);

		$register_page(
			new Page(
				'integration',
				__(
					'Integration',
					'unofficial-convertkit'
				),
				static function() use ( $current_page, $integrations ) {
					$not_found_msg = sprintf(
						// translators: %s the id of the not founded integration
						__( 'No such integration: %s', 'unofficial-convertkit' ),
						$_GET['id'] ?? ''
					);

					if ( null === $current_page ) {
						/** @noinspection ForgottenDebugOutputInspection */
						wp_die( $not_found_msg );
					}

					$integration = $integrations->get_by_identifier( $current_page->get_identifier() );

					if ( $integration instanceof Default_Integration_Hooks ) {
						/** @noinspection ForgottenDebugOutputInspection */
						wp_die( $not_found_msg );
					}

					$integration_view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-default-integration-option-page.php';
					$integration_view( $integration, get_rest_api()->list_forms() );
				},
				$breadcrumbs
			)
		);
	}

	/**
	 * @param callable $register_tab
	 *
	 * @internal
	 */
	public function register_tab( callable $register_tab ) {

		$i18n = __( 'Integrations', 'unofficial-convertkit' );
		$register_tab(
			new Tab(
				'integrations',
				$i18n,
				array( $this->integration_controller, 'index' ),
				array(
					$this->breadcrumb,
				)
			)
		);
	}
}
