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
		add_action( 'init', array( $this, 'embed_register' ) );
	}

	public function embed_register() {
		wp_embed_register_handler( 'convertkit', '/https:\/\/(.+)\.ck\.page\/(\w+)$/s', array( $this, 'embed_handler' ) );
	}

	/**
	 * @param array $matches
	 * @param $attr
	 * @param string $url
	 * @param $rawattr
	 *
	 * @return false|string
	 */
	public function embed_handler( $matches, $attr, $url, $rawattr ) {
		$forms = get_rest_api()->lists_forms()->forms;

		$form = array_search( $matches[2] ?? '', array_column( $forms, 'uid' ), true );

		//TODO: @Danny of this behaviour to proper document this.
		//prevent the user from giving a invalid url
		if ( false === $form || $form->embed_url ?? null !== $url ) {
			return false;
		}

		$shortcode = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/forms/convertkit-form.php';
		ob_start();
		$shortcode( $form->uid, $form->embed_url );

		return ob_get_clean();
	}
}
