<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Admin\Page;
use UnofficialConvertKit\Admin\Tab;
use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;
use UnofficialConvertKit\Integrations\Integration_Repository;
use UnofficialConvertKit\Integrations\Integrations_Hooks as General_Integrations_Hooks;
use UnofficialConvertKit\Integrations\Registration_Form_Integration;

/**
 * All the hooks related to the admin interface for the integrations.
 *
 * Class Integrations_Hooks
 * @package UnofficialConvertKit\Integrations\Admin
 */
class Integrations_Hooks implements Hooks {

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

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'unofficial_convertkit_admin_register_tab', array( $this, 'register_tab' ) );
		add_action( 'unofficial_convertkit_admin_register_page', array( $this, 'register_page' ) );

		require __DIR__ . '/class-default-integration-hooks.php';
		//Register all the admin page that uses the default options.
		$get = array( $this->integration_repository, 'get_by_identifier' );
		$hooker->add_hook( new Default_Integration_Hooks( $get( Comment_Form_Integration::IDENTIFIER ) ) );
		$hooker->add_hook( new Default_Integration_Hooks( $get( Registration_Form_Integration::IDENTIFIER ) ) );

		require __DIR__ . '/class-contact-form-7-hooks.php';
		$hooker->add_hook( new Contact_Form_7_Hooks( $get( Contact_Form_7_Integration::IDENTIFIER ) ) );
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
		$id = $_GET['id'] ?? '';
		$register_page(
			new Page(
				'integration',
				__(
					'Integration',
					'unofficial-convertkit'
				),
				array( $this->integration_controller, 'show' ),
				apply_filters( 'unofficial_convertkit_integrations_admin_breadcrumb_' . $id, array( $this->breadcrumb ) )
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
