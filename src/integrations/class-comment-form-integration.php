<?php

namespace UnofficialConvertKit\Integrations;

final class Comment_Form_Integration extends Default_Integration {

	const IDENTIFIER = 'comment_form';

	/**
	 * @inheritDoc
	 */
	public function get_identifier(): string {
		return self::IDENTIFIER;
	}

	/**
	 * @inheritDoc
	 */
	public function get_name(): string {
		return __( 'Comment From', 'unofficial-convertkit' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_description(): string {
		return __( 'Subscribes people from your WordPress comment form.', 'unofficial-convertkit' );
	}

	/**
	 * @inheritDoc
	 */
	public function is_available(): bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		return array(
			array(
				'comment_post',
				static function( $id, $comment_approved ) {
					if ( 'spam' === $comment_approved ) {
						return null;
					}

					return get_comment_author_email( $id );
				},
				10,
				2,
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks() {
		require __DIR__ . '/hooks/class-comment-form-hooks.php';

		return new Comment_Form_Hooks( $this );
	}
}
