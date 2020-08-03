<?php
/*
Plugin Name:       Unofficial ConvertKit
Plugin URI:        https://ckforwp.com/
Description:       WordPress plugin for ConvertKit
Version: 1.0.0
Requires at least: 5
Requires PHP:      7
Author:            ibericode
Author URI:        https://ibericode.com/
License:           GPL-3.0-only
License URI:       https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:       unofficial-convertkit
Domain Path:       /languages
*/

namespace UnofficialConvertKit;

defined( 'ABSPATH' ) or exit;

use UnofficialConvertKit\Admin\Page_Hooks;
use UnofficialConvertKit\API\API_Hooks;
use UnofficialConvertKit\Forms\Forms_Hooks;
use UnofficialConvertKit\Integrations\Integrations_Hooks;

define( 'UNOFFICIAL_CONVERTKIT_VERSION', '1.0.0' );
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
		$hooker = new Hooks_Service();

		$hooks = array();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/class-default-hooks.php';
		$hooks[] = new Default_Hooks();

		//Hooks for mostly every request.
		//Todo: hook only when needed
		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/integrations/hooks/class-integrations-hooks.php';
		$hooks[] = new Integrations_Hooks();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/forms/hooks/class-forms-hooks.php';
		$hooks[] = new Forms_Hooks();

		require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/api/hooks/class-api-hooks.php';
		$hooks[] = new API_Hooks();

		//Admin hooks
		if ( is_admin() ) {
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/admin/bootstrap.php';
			$hooks[] = new Page_Hooks();
		}

		foreach ( $hooks as $hook ) {
			$hooker->add_hook( $hook );
		}

		//Hook all hooks
		$hooker->hook( $hooker );
	},
	8
);
