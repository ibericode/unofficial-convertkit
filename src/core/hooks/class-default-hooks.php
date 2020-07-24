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

		global $pagenow;
		if ( 'plugins.php' === $pagenow ) {
			add_filter( 'plugin_action_links_' . plugin_basename( UNOFFICIAL_CONVERTKIT_PLUGIN_FILE ), array( $this, 'plugin_settings_link' ) );
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
	 *
	 * @internal
	 * @ignore
	 */
	public function register_scripts_from_assets() {
		$assets = require UNOFFICIAL_CONVERKIT_ASSETS_DIR . '/assets.php';

		foreach ( $assets as $asset => $options ) {
			$relative_asset_dir = str_replace( UNOFFICIAL_CONVERTKIT_PLUGIN_DIR, '', UNOFFICIAL_CONVERKIT_ASSETS_DIR );
			$src                = plugins_url( sprintf( '%s/%s', $relative_asset_dir, $asset ), UNOFFICIAL_CONVERTKIT_PLUGIN_FILE );
			wp_register_script( $asset, $src, $options['dependencies'] ?? array(), $options['version'] ?? false );
		}
	}

	/**
	 * Add link to settings page.
	 *
	 * @param array $links
	 *
	 * @return array
	 * @internal
	 * @ignore
	 */
	public function plugin_settings_link( array $links ): array {
		$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=unofficial-convertkit-settings' ), esc_html__( 'Settings', 'unofficial-convertkit' ) );
		array_unshift( $links, $settings_link );
		return $links;
	}
}
