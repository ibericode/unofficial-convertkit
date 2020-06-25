<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooks;

final class Comment_Form_Integration implements Integration {

	const IDENTIFIER = 'comment_form';

	private $default_options = array(
		'form-ids' => array(),
	);

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
		return \get_option( 'unofficial_convertkit_integration_enabled' )[ $this->get_identifier() ] ?? false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_options(): array {
		// TODO: integrate in the settings from
		return array_merge( $this->default_options, (array) get_option( 'unofficial_convertkit_integrations_comment_form' ) );
	}

	/**
	 * @return array|array[]
	 */
	public function actions(): array {
		return array(
			array(
				'comment_post',
				function( $id ) {
					return get_comment_author_email( $id );
				},
			),
		);
	}

	/**
	 * {@internal}
	 */
	public function get_hooks(): Hooks {
		require __DIR__ . '/hooks/class-comment-form-hooks.php';

		return new Comment_Form_Hooks();
	}
}
