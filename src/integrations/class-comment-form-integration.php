<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooks;

final class Comment_Form_Integration implements Integration {

	const IDENTIFIER = 'comment_form';

	static private $default_options = array(
		'enabled'        => false,
		'form-ids'       => array(),
		'default-css'    => false,
		'checkbox-label' => null,
	);

	/**
	 * @var array
	 */
	private $options;

	public function __construct() {
		$options       = get_option( 'unofficial_convertkit_integrations_comment_form', static::$default_options );
		$this->options = array_merge( static::$default_options, $options );
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
		return $this->options['enabled'] ?? false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_options(): array {
		// TODO: integrate in the settings from
		return $this->options;
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
