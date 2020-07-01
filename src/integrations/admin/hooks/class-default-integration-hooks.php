<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Integration;
use function UnofficialConvertKit\validate_with_notice;

/**
 * Register this class if the the `Integrations_Hooks` if you have manageable options with the default options.
 * Extends this class if you need more or specific control.
 * When the integration have manageable options but not not the default options create your own hooks file and register it.
 *
 * Class Integration_Hooks
 * @package UnofficialConvertKit\Integrations\Admin
 */
class Default_Integration_Hooks implements Hooks {

	/**
	 * @var string the identifier of the integration
	 */
	private $id;

	/**
	 * @var bool
	 */
	private $uses_enabled;

	public function __construct( string $identifier, bool $uses_enabled = true ) {
		$this->id           = $identifier;
		$this->uses_enabled = $uses_enabled;
	}

	public function hook( Hooker $hooker ) {
		add_filter(
			'unofficial_convertkit_integrations_admin_menu_slug_' . $this->id,
			array( $this, 'settings_page_slug' )
		);

		add_filter(
			'unofficial_convertkit_integrations_admin_sanitize_' . $this->id,
			array( $this, 'sanitize_default' ),
			10,
			2
		);
	}

	/**
	 * Add settings page slug.
	 *
	 * @return string
	 */
	final public function settings_page_slug(): string {
		return sprintf(
			'admin.php?page=%s&id=%s',
			Integrations_Hooks::MENU_SLUG,
			$this->id
		);
	}

	/**
	 * This method checks the validates and sanitize the default settings/options
	 *
	 * @param array $settings
	 * @param Integration $integration
	 *
	 * @return array
	 */
	final public function sanitize_default( array $settings, Integration $integration ): array {
		$options = $integration->get_options();

		require __DIR__ . '/../validators/class-default-integration-validator.php';
		if ( ! validate_with_notice( $settings, new Default_Integration_Validator( $this->uses_enabled ) ) ) {
			return $options;
		}

		$options['enabled'] = $this->uses_enabled && (bool) $settings['enabled'] ?? false;

		if ( ! $options['enabled'] ) {
			//Don't execute the rest not important, because it is disabled
			return $options;
		}

		$form_ids = array();

		//Sanitize to array
		foreach ( $settings['form-ids'] ?? array() as $form_id ) {
			$form_id = (int) $form_id;

			//Ignore cases when the not proper converted
			if ( 0 === $form_id || 1 === $form_id ) {
				continue;
			}

			$form_ids[] = $form_id;
		}

		$options['form-ids'] = $form_ids;

		$options['checkbox-label'] = (string) $settings['checkbox-label'];
		$options['implicit']       = (bool) $settings['implicit'];
		$options['load-css']       = (bool) $settings['load-css'];

		return $this->sanitize_options( $settings, $integration );
	}

	/**
	 * Override this method when there are custom settings/options.
	 *
	 * @param array $settings
	 * @param Integration $integration
	 *
	 * @return array
	 */
	public function sanitize_options( array $settings, Integration $integration ): array {
		return $settings;
	}
}
