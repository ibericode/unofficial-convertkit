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

use UnofficialConvertKit\Integration\Integrations_Hooks;
use UnofficialConvertKit\Settings\Settings_Hooks;

define( 'UNOFFICIAL_CONVERTKIT_VERSION', '0.0.0' );
define( 'UNOFFICIAL_CONVERTKIT', 'unofficial-convertkit' );
define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_DIR', __DIR__ );
define( 'UNOFFICIAL_CONVERTKIT_SRC_DIR', __DIR__ . '/src' );

//Bootstrap lib directly.
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/bootstrap.php';

add_action(
	'plugins_loaded',
	function() {
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/bootstrap.php';

		$hooker = new Hooks_Service();

		/**
		 * Settings is mostly admin hooks
		 */
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/settings/hooks/class-settings-hooks.php';
		$hooker->add_hook( new Settings_Hooks() );

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/integrations/hooks/class-integrations-hooks.php';
		$hooker->add_hook( new Integrations_Hooks() );

		//Hook all hooks
		$hooker->hook( $hooker );
	},
	8
);

