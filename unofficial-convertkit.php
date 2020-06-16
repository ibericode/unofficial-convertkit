<?php
/**
 * Plugin Name:       Unofficial ConvertKit
 * Plugin URI:
 * Description:       WordPress plugin for ConvertKit
 * Version:           0.0.0
 * Requires at least: 5
 * Requires PHP:      7
 * License:           GPL-3.0-only
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       unofficial-convertkit
 * Domain Path:       /languages
 */

namespace UnofficialConvertKit;

define( 'UNOFFICIAL_CONVERTKIT_VERSION', '0.0.0' );
define( 'UNOFFICIAL_CONVERTKIT', 'unofficial-convertkit' );
define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_DIR', __DIR__ );
define( 'UNOFFICIAL_CONVERTKIT_SRC_DIR', __DIR__ . '/src' );

add_action(
	'plugins_loaded',
	function() {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/bootstrap.php';

		$hook = new Hooks_Service();

		if ( is_admin() ) {
			/**
			 * Register all the admin hooks
			 */
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/hooks/class-settings-hooks.php';
			$hook->add_hook( new Settings_Hooks() );
		}

		$hook->hook();
	},
	8
);

