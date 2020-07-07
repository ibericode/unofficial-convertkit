<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\enqueue_script;

class Gutenberg_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue the scripts for the gutenberg editor
	 *
	 * @internal
	 */
	public function enqueue_scripts() {
		enqueue_script( 'js/block-form.js' );
	}
}
