<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

/**
 * Class Comment_Form_Hooks
 * @package UnofficialConvertKit\Integration
 *
 * @see Comment_Form_Integration::get_hooks()
 */
class Comment_Form_Hooks implements Hooks {

	private $checkbox_is_rendered = false;

	/**
	 * @var Comment_Form_Integration
	 */
	private $integration;

	public function __construct( Integration $integration ) {
		$this->integration = $integration;
	}

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		add_filter( 'comment_form_submit_field', array( $this, 'render_above_submit_button' ), 80 );
		add_action( 'comment_form', array( $this, 'add_comment_form_select_box' ), 80 );
	}

	public function render_above_submit_button( string $submit_button ) {
		$this->render_comment_form_select_box();

		echo $submit_button;
	}

	/**
	 * Show a checkbox under the comment form.
	 *
	 * @ignore
	 * @internal
	 */
	public function render_comment_form_select_box() {
		if ( $this->checkbox_is_rendered ) {
			return;
		}

		call_user_func(
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/comment-form-select-box.php',
			$this->integration->get_options()['checkbox-label']
		);

		$this->checkbox_is_rendered = true;
	}

}
