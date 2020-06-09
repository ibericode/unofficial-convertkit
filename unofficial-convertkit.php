<?php
/**
 * Plugin Name:       Unofficial ConvertKit
 * Plugin URI:
 * Description:       Wordpress plugin for ConvertKit
 * Version:           0.0.0
 * Requires at least: 5
 * Requires PHP:      7
 * License:           GPL-3.0-only
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       unofficial-convertkit
 * Domain Path:       /languages
 */

namespace UnofficialConvertKit;

/**
 * Register all the admin hooks
 */
require __DIR__ . '/src/hooks/class-admin-hooks.php';
$admin = new Admin_Hooks();
$admin->hook();