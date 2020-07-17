<?php

namespace UnofficialConvertKit\Forms\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\enqueue_script;

class Gutenberg_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue the scripts for the gutenberg editor
	 *
	 * @internal
	 */
	public function enqueue_assets() {
		//Development scripts
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			wp_enqueue_script( 'hr-entries', plugins_url( 'js/hr-entries.js', UNOFFICIAL_CONVERKIT_ASSETS_DIR ), array() );
		}

		enqueue_script( 'js/block-form.js' );
	}
}
