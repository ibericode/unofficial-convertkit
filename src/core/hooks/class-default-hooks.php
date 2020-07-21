<?php

namespace UnofficialConvertKit;

class Default_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_filter( 'default_option_unofficial_convertkit_settings', array( $this, 'set_default_options' ) );

		if ( ! is_ajax() ) {
			add_action( 'init', array( $this, 'register_scripts_from_assets' ) );
		}
	}

	/**
	 * @return array|string[]
	 */
	public function set_default_options(): array {
		return get_default_options();
	}

	/**
	 * @see UNOFFICIAL_CONVERKIT_ASSETS_DIR
	 * @see assets.php
	 */
	public function register_scripts_from_assets() {
		$assets = require UNOFFICIAL_CONVERKIT_ASSETS_DIR . '/assets.php';

		foreach ( $assets as $asset => $options ) {
			$relative_asset_dir = str_replace( UNOFFICIAL_CONVERTKIT_PLUGIN_DIR, '', UNOFFICIAL_CONVERKIT_ASSETS_DIR );
			$src                = plugins_url( sprintf( '%s/%s', $relative_asset_dir, $asset ), UNOFFICIAL_CONVERTKIT_PLUGIN_FILE );
			wp_register_script( $asset, $src, $options['dependencies'] ?? array(), $options['version'] ?? false );
		}
	}
}
