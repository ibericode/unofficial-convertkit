<?php

namespace UnofficialConvertKit\Forms;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\get_rest_api;

class Forms_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action(
			'init',
			function() {
				$this->register_block();
				$this->register_embed();
			}
		);
	}

	/**
	 * Register the embed
	 */
	public function register_embed() {
		wp_embed_register_handler( 'convertkit', '/https:\/\/(.+)\.ck\.page\/(\w+)$/s', array( $this, 'render_embed' ) );
	}

	/**
	 * register the dynamic block
	 */
	public function register_block() {
		register_block_type(
			'unofficial-convertkit/form',
			array(
				'editor_script'   => 'js/block-form.js',
				'render_callback' => array( $this, 'render_block' ),
			)
		);
	}

	/**
	 * @param $block_attributes
	 * @param $content
	 *
	 * @return false|string
	 */
	public function render_block( $block_attributes, $content ) {
		return $this->convertkit_form( '24c15b916f', 'https://deft-thinker-8999.ck.page/24c15b916f/index.js' );
	}

	/**
	 * @param array $matches
	 * @param $attr
	 * @param string $url
	 * @param $rawattr
	 *
	 * @return false|string
	 */
	public function render_embed( $matches, $attr, $url, $rawattr ) {
		$forms = get_rest_api()->lists_forms()->forms;

		$form = array_search( $matches[2] ?? '', array_column( $forms, 'uid' ), true );

		//TODO: @Danny of this behaviour to proper document this.
		//prevent the user from giving a invalid url
		if ( false === $form || $form->embed_url ?? null !== $url ) {
			return false;
		}

		return $this->convertkit_form( $form->uid, $form->embed_js );
	}

	/**
	 * @param string $uid
	 * @param string $embed_js
	 *
	 * @return false|string
	 */
	protected function convertkit_form( string $uid, string $embed_js ) {
		$shortcode = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/forms/convertkit-form.php';
		ob_start();
		$shortcode( $uid, $embed_js );

		return ob_get_clean();
	}
}
