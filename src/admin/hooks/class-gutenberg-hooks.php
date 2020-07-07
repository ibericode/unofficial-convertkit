<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Gutenberg_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		wp_enqueue_script(
			'myplugin-block',
			plugins_url( UNOFFICIAL_CONVERKIT_ASSETS_DIR . '/js/block-form.js', UNOFFICIAL_CONVERTKIT_PLUGIN_FILE ),
			array( 'wp-blocks', 'wp-element' )
		);
	}
}
