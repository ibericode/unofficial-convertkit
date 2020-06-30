<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Integration;

abstract class Integration_Hook implements Hooks {

	/**
	 * @var string the identifier of the integration
	 */
	private $id;

	public function __construct( string $identifier ) {
		$this->id = $identifier;
	}

	public function hook( Hooker $hooker ) {
		add_filter(
			'unofficial_convertkit_integrations_admin_menu_slug_' . $this->id,
			array( $this, 'settings_page_slug' )
		);

		add_filter(
			'unofficial_convertkit_integrations_admin_sanitize_' . $this->id,
			array( $this, 'validate_settings' ),
			10,
			2
		);
	}

	/**
	 * Add settings page slug.
	 *
	 * @return string
	 */
	final public function settings_page_slug() {
		return sprintf(
			'admin.php?page=%s&id=%s',
			Integrations_Hooks::MENU_SLUG,
			$this->id
		);
	}

	/**
	 * Is called when the identifier of the form is submitted
	 *
	 * @param array $settings
	 * @param Integration $integration
	 *
	 * @return array
	 */
	abstract function sanitize_options( array $settings, Integration $integration ): array;
}
