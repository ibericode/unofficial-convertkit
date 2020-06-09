<?php

namespace UnofficialConvertKit;

class Admin_Hooks {

	/**
	 * Register all the hooks which belong to the Admin dashboard
	 */
	public function hook() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
	}

	/**
	 * Add page to the side bar.
	 */
	public function add_settings_page() {
		add_options_page(
			__( 'Unofficial ConvertKit settings', 'unofficial-convertkit' ),
			__( 'Unofficial ConvertKit', 'unofficial-convertkit' ),
			'manage_options',
			'unofficial-convertkit-settings-page',
			function() {
				echo 'page';
			}
		);
	}
}
