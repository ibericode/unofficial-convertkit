<?php

namespace UnofficialConvertKit\Forms;

use Exception;
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
				$this->register_shortcode();
			}
		);
	}

	/**
	 * Register the embed
	 *
	 * @internal
	 * @ignore
	 */
	public function register_shortcode() {
		add_shortcode( 'unofficial-convertkit-form', array( $this, 'render_shortcode' ) );
	}

	/**
	 * @param $atts
	 * @param $contents
	 *
	 * @return string
	 *
	 * @internal
	 * @ignore
	 */
	public function render_shortcode( $atts, $contents ): string {
		try {
			$form = get_rest_api()->list_form( $atts['id'] ?? 0 );
		} catch ( Exception $e ) {
			return '';
		}

		return $this->convertkit_form( $form->uid, $form->embed_js );
	}

	/**
	 * register the dynamic block
	 *
	 * @internal
	 * @ignore
	 */
	public function register_block() {
		register_block_type(
			'unofficial-convertkit/form',
			array(
				'editor_script'   => 'unofficial-convertkit/js/block-form.js',
				'attributes'      => array(
					'formId' => array(
						'type'    => 'int',
						'default' => 0,
					),
				),
				'render_callback' => array( $this, 'render_block' ),
			)
		);
	}

	/**
	 * Render the block
	 *
	 * @param $attributes
	 * @param $content
	 *
	 * @return bool|string
	 *
	 * @internal
	 * @ignore
	 */
	public function render_block( $attributes, $content ) {
		$id = $attributes['formId'] ?? 0;

		if ( 0 === $id ) {
			return false;
		}

		return sprintf( '[unofficial-convertkit-form id=%s]', $id );
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
