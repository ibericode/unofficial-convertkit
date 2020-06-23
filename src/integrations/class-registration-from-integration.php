<?php

namespace UnofficialConvertKit\Integration;

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
		// TODO: Implement get_name() method.
	}

	/**
	 * @inheritDoc
	 */
	public function get_description(): string {
		// TODO: Implement get_description() method.
	}

	/**
	 * @inheritDoc
	 */
	public function is_available(): bool {
		// TODO: Implement is_available() method.
	}

	/**
	 * @inheritDoc
	 */
	public function is_active(): bool {
		// TODO: Implement is_active() method.
	}

	/**
	 * @inheritDoc
	 */
	public function get_options(): array {
		// TODO: Implement get_options() method.
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		// TODO: Implement actions() method.
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks(): Hooks {
		// TODO: Implement get_hooks() method.
	}
}
