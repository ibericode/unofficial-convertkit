<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

/**
 * Class Comment_Form_Hooks
 * @package UnofficialConvertKit\Integration
 *
 * @see Comment_Form_Integration::get_hooks()
 */
class Comment_Form_Hooks implements Hooks {

	private $checkbox_is_shown = false;

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		add_filter( 'add_checkbox_before_submit_button', array( $this, 'add_comment_form_select_box' ), 90 );

		if ( ! $this->checkbox_is_shown ) {
			add_action( 'comment_form', array( $this, 'add_comment_form_select_box' ), 90 );
		}
	}

	/**
	 * Show a checkbox under the comment form.
	 *
	 * @ignore
	 * @internal
	 */
	public function add_comment_form_select_box() {
		call_user_func(
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/comment-form-select-box.php'
		);

		$this->checkbox_is_shown = true;
	}

}
