<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooks;

class Contact_Form_7_Integration implements Integration {

	const IDENTIFIER = 'contact-form-7';

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
		//Todo: find replace function for `is_plugin_active`
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function is_active(): bool {
		//TODO: manage with the settings form
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_options(): array {
		// TODO: manage with the settings form

		return array(
			'form-ids' => array( 1441335 ),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		return array();
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks(): Hooks {
		require __DIR__ . '/hooks/class-contact-form-7-hooks.php';

		return new Contact_Form_7_Hooks();
	}
}
