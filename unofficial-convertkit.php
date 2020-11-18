<?php
/*
Plugin Name:       Unofficial ConvertKit
Plugin URI:        https://ckforwp.com/
Description:       WordPress plugin for ConvertKit
Version: 1.0.3
Requires at least: 5.0
Requires PHP:      7.0
Author:            ibericode
Author URI:        https://ibericode.com/
License:           GPL-3.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:       unofficial-convertkit
Domain Path:       /languages
*/

namespace UnofficialConvertKit;

defined( 'ABSPATH' ) or exit;

use UnofficialConvertKit\Admin\Page_Hooks;
use UnofficialConvertKit\API\API_Hooks;
use UnofficialConvertKit\Debug\Debug_Hooks;
use UnofficialConvertKit\Forms\Forms_Hooks;
use UnofficialConvertKit\Integrations\Integrations_Hooks;

define( 'UNOFFICIAL_CONVERTKIT_VERSION', '1.0.3' );
define( 'UNOFFICIAL_CONVERTKIT', 'unofficial-convertkit' );
define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_DIR', __DIR__ );
define( 'UNOFFICIAL_CONVERTKIT_SRC_DIR', __DIR__ . '/src' );
define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_FILE', __FILE__ );
define( 'UNOFFICIAL_CONVERTKIT_ASSETS_DIR', sprintf( '%s/dist/%s', __DIR__, defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'dev' : 'prod' ) );

//Bootstrap lib directly.
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/lib/api/v3/bootstrap.php';
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/bootstrap.php';

add_action(
	'plugins_loaded',
	static function () {

		// Admin-only hooks
		if ( is_admin() ) {
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/admin/bootstrap.php';
			( new Page_Hooks() )->hook();
		}

		// Global hooks
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/class-default-hooks.php';
		( new Default_Hooks() )->hook();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/integrations/hooks/class-integrations-hooks.php';
		( new Integrations_Hooks() )->hook();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/forms/hooks/class-forms-hooks.php';
		( new Forms_Hooks() )->hook();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/api/hooks/class-api-hooks.php';
		( new API_Hooks() )->hook();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/debug/hooks/class-debug-hooks.php';
		( new Debug_Hooks() )->hook();

		/**
		 * Fires after the unofficial ConvertKit is bootstrapped.
		 */
		do_action( 'unofficial_convertkit_bootstrapped' );
	},
	8
);
