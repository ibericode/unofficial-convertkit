<?php

namespace UnofficialConvertKit\Debug\Admin;

use UnofficialConvertKit\Admin\Tab;

class Debug_Hooks {
	/**
	 * Hooks.
	 */
	public function hook() {
		add_action( 'unofficial_convertkit_admin_register_tab', array( $this, 'register_tab' ) );
	}

	/**
	 * @param callable $register_tab
	 */
	public function register_tab( callable $register_tab ) {
		require __DIR__ . '/../controller/class-debug-controller.php';

		$register_tab(
			new Tab(
				'debug',
				__( 'Debug', 'unofficial-convertkit' ),
				array( new Debug_Controller(), 'index' ),
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
