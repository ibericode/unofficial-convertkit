<?php

namespace UnofficialConvertKit\Forms;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Forms_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'init', array( $this, 'shortcodes_init' ) );
	}

	/**
	 * @internal
	 * @ignore
	 */
	public function shortcodes_init() {
		add_shortcode( 'unofficial-convertkit-forms', array( $this, 'shortcode_unofficial_convertkit_forms_handler' ) );
	}

	/**
	 * @param array $atts
	 * @param null $content
	 * @param string $tag
	 *
	 * @return string|null
	 * @internal
	 *
	 * @see https://developer.wordpress.org/plugins/shortcodes/shortcodes-with-parameters/
	 * @ignore
	 */
	public function shortcode_unofficial_convertkit_forms_handler( $atts = array(), $content = null, $tag = '' ) {
		$atts = array_change_key_case( (array) $atts, CASE_LOWER );

		$uc_forms_atts = shortcode_atts(
			array(
				'form' => null,
			),
			$atts,
			$tag
		);

		if ( null === $uc_forms_atts ) {
			return $content;
		}

		$shortcode = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/forms/shortcode-forms.php';
		ob_start();
		$shortcode();
		$content .= ob_get_clean();

		return $content;
	}
}
