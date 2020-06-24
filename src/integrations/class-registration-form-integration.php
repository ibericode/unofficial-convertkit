<?php

namespace UnofficialConvertKit\Integration;

use Registration_Form_Hooks;
use UnofficialConvertKit\Hooks;

class Registration_Form_Integration implements Integration {

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
	public function is_active(): bool {
		//TODO: manage through settings form
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_options(): array {
		//TODO: manage through settings form
		return array(
			'form-ids' => array( 1441335 ),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		return array(
			array(
				'user_register',
				function( $user_id ) {
					return get_userdata( $user_id )->user_email ?? '';
				},
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks(): Hooks {
		require __DIR__ . '/hooks/class-registration-form-hooks.php';

		return new Registration_Form_Hooks();
	}
}