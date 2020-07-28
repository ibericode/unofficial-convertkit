<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\get_asset_src;
use function UnofficialConvertKit\get_default_options;
use function UnofficialConvertKit\get_options;

class Settings_Controller {

	private $default_tab = 'general';

	/**
	 * The plugin page.
	 */
	public function index() {

		wp_enqueue_style( 'unofficial-convertkit-admin-style', get_asset_src( 'css/admin.css' ), array(), UNOFFICIAL_CONVERTKIT_VERSION );

		$is_default_options = get_options() === get_default_options();

		$selected_tab = $_GET['tab'] ?? $this->default_tab;

		if ( $is_default_options && $this->default_tab !== $selected_tab ) {
			$selected_tab = $this->default_tab;
		}

		$settings = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-settings-tabs.php';

		$settings( $selected_tab, $is_default_options );
	}

	/**
	 * @param $options
	 *
	 * @return mixed
	 */
	public function redirect_by_empty_options( $options ) {
		global $pagenow;

		$is_general = 'options-general.php' === $pagenow && ( $_GET['tab'] ?? $this->default_tab ) === 'general';

		if ( ! $is_general && ( empty( $options ) || get_default_options() === $options ) ) {
			wp_redirect( '/wp-admin/options-general.php?page=unofficial-convertkit-settings&tab=general' );
			exit();
		}

		return $options;
	}
}
