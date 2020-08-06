<?php

namespace UnofficialConvertKit\Integrations;

/**
 * Class Comment_Form_Hooks
 * @package UnofficialConvertKit\Integration
 *
 * @see Comment_Form_Integration::get_hooks()
 */
class Comment_Form_Hooks extends Integration_Hooks {

	private $checkbox_is_rendered = false;

	public function hook() {
		parent::hook();
		add_action( 'comment_form', array( $this, 'render_comment_form_select_box' ), 80 );
		add_filter( 'comment_form_submit_field', array( $this, 'render_above_submit_button' ), 80 );
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

		$this->display_checkbox();

		$this->checkbox_is_rendered = true;
	}

}
