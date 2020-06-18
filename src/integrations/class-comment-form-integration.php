<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;

class Comment_Form_Integration implements Integration {

	/**
	 * @param Hooker $hooker
	 */
	public function hook( Hooker $hooker ) {
	}

	public function get_identifier(): string {
		return 'unofficial-convertkit-comment-form-integration';
	}

	public function get_name(): string {
		return __( 'Comment From', 'unofficial-convertkit' );
	}

	public function get_description(): string {
		return __( 'Subscribes people from your WordPress comment form.', 'unofficial-convertkit' );
	}

	public function is_available(): bool {
		return true;
	}

	public function is_active(): bool {
		// TODO: Implement is_active() method.
		return true;
	}

	public function get_options(): array {
		// TODO: Implement get_options() method.
		return array();
	}
}
