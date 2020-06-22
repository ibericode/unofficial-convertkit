<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

final class Comment_Form_Integration implements Integration {

	const IDENTIFIER = 'comment_form';

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {

	}

	/**
	 * {@inheritDoc}
	 */
	public function get_identifier(): string {
		return self::IDENTIFIER;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_name(): string {
		return __( 'Comment From', 'unofficial-convertkit' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_description(): string {
		return __( 'Subscribes people from your WordPress comment form.', 'unofficial-convertkit' );
	}

	/**
	 * {@inheritDoc}
	 */
	public function is_available(): bool {
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function is_active(): bool {
		// TODO: Implement is_active() method.
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_options(): array {
		// TODO: Implement get_options() method.
		return array();
	}

	/**
	 * {@internal}
	 */
	public function get_hooks(): Hooks {
		require __DIR__ . '/hooks/class-comment-form-hooks.php';

		return new Comment_Form_Hooks();
	}
}
