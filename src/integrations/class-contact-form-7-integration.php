<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\is_active_plugin;

class Contact_Form_7_Integration extends Default_Integration {

	const IDENTIFIER = 'contact_form_7';

	const WPCF7_TAG = 'unofficial_convertkit_checkbox';

	protected $uses_enabled = false;

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
		return 'Contact Form 7';
	}

	/**
	 * @inheritDoc
	 */
	public function get_description(): string {
		return __( 'Subscribes people from Contact Form 7 forms.', 'unofficial_convertkit' );
	}

	/**
	 * @inheritDoc
	 */
	public function is_available(): bool {
		return defined( 'WPCF7_PLUGIN_BASENAME' ) && is_active_plugin( WPCF7_PLUGIN_BASENAME );
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		//TODO: implement action() method.
		return array(
			array(
				'wpcf7_mail_sent',
				static function() {
					//TODO: extract the email from the form.
					return null;
				},
			),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks() {
		require __DIR__ . '/hooks/class-contact-form-7-hooks.php';

		return new Contact_Form_7_Hooks( $this );
	}
}
