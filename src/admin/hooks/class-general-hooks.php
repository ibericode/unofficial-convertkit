<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\get_default_options;

class General_Hooks implements Hooks {

	/**
	 * @var General_Controller
	 */
	private $general_controller;

	public function __construct() {
		require __DIR__ . '/../controllers/class-general-controller.php';
		$this->general_controller = new General_Controller();
	}

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'unofficial_convertkit_admin_register_tab', array( $this, 'register_tab' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_filter( 'sanitize_option_unofficial_convertkit_settings', array( $this->general_controller, 'save' ) );
	}

	/**
	 * Add page to the side bar.
	 *
	 * @internal
	 * @ignore
	 */
	public function register_settings() {
		register_setting(
			'unofficial_convertkit',
			'unofficial_convertkit_settings',
			array(
				'type'    => 'array',
				'default' => get_default_options(),
			)
		);
	}

	/**
	 * @param callable $register
	 *
	 * @internal
	 */
	public function register_tab( callable $register ) {
		$register(
			new Tab(
				'general',
				__( 'General', 'unofficial-convertkit' ),
				array( $this->general_controller, 'index' ),
				array(),
				-1
			)
		);
	}
}
