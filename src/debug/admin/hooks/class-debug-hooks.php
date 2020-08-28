<?php

namespace UnofficialConvertKit\Debug\Admin;

use UnofficialConvertKit\Admin\Tab;

class Debug_Hooks {

	/**
	 * @var Debug_Controller
	 */
	private $debug_controller;

	public function __construct() {
		require __DIR__ . '/../controller/class-debug-controller.php';
		$this->debug_controller = new Debug_Controller();
	}

	/**
	 * Hooks.
	 */
	public function hook() {
		add_action( 'unofficial_convertkit_admin_register_tab', array( $this, 'register_tab' ) );
		add_action( 'admin_post_unofficial_convertkit_remove_log', array( $this->debug_controller, 'remove_log' ) );
	}

	/**
	 * @param callable $register_tab
	 */
	public function register_tab( callable $register_tab ) {

		$register_tab(
			new Tab(
				'debug',
				__( 'Debug', 'unofficial-convertkit' ),
				array( $this->debug_controller, 'index' ),
				array(
					array(
						'breadcrumb' => __( 'Debug', 'unofficial-convertkit' ),
						'url'        => admin_url( 'options-general.php?page=unofficial_convertkit&tab=debug' ),
					),
				)
			)
		);
	}
}
