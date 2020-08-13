<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Integrations\Admin\Contact_Form_7_Hooks as Admin_Contact_Form_7_Hooks;
use UnofficialConvertKit\Integrations\Admin\Default_Integration_Hooks;
use WPCF7_ContactForm;
use WPCF7_FormTag;

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
		return defined( 'WPCF7_PLUGIN_BASENAME' );
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		return array(
			array(
				'wpcf7_mail_sent',
				static function( WPCF7_ContactForm $form ) {
					/** @var WPCF7_FormTag $checkbox_tag */
					$checkbox_tag = $form->scan_form_tags( array( 'type' => 'unofficial_convertkit_checkbox' ) )[0] ?? null;

					//Return null if the checkbox is not in the form.
					if ( is_null( $checkbox_tag ) ) {
						return null;
					}

					//Get it by name of the option from the option.
					if ( $checkbox_tag->has_option( 'email-field' ) ) {
						/**
						 * @var WPCF7_FormTag|null $email_tag
						 */
						$email_tag = $form->scan_form_tags( array( 'name' => $checkbox_tag->get_option( 'email-field' ) ) )[0] ?? null;
					}

					$email_tag = $email_tag ?? $form->scan_form_tags( array( 'type' => 'email*' ) )[0] ?? null;

					if ( is_null( $email_tag ) ) {
						return null;
					}

					$key = empty( $email_tag->name ) ? $email_tag->type : $email_tag->name;

					return $_POST[ $key ] ?? null;
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

	/**
	 * @inheritDoc
	 */
	public function admin_hooks(): Default_Integration_Hooks {
		require __DIR__ . '/admin/hooks/class-contact-form-7-hooks.php';
		return new Admin_Contact_Form_7_Hooks( $this );
	}
}
