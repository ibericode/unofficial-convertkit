<?php

namespace UnofficialConvertKit\Integrations;

class Registration_Form_Integration extends Default_Integration {

	const IDENTIFIER = 'registration_form';

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
		return __( 'Registration Form', 'unofficial-convertkit' );
	}

	/**
	 * @inheritDoc
	 */
	public function get_description(): string {
		return __( 'Subscribes people from your WordPress registration form.', 'unofficial-convertkit' );
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
				'user_register',
				static function( $user_id ) {
					return get_userdata( $user_id )->user_email ?? '';
				},
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks() {
		require __DIR__ . '/hooks/class-registration-form-hooks.php';

		return new Registration_Form_Hooks( $this );
	}
}
