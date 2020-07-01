<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Default_Integration;
use function UnofficialConvertKit\validate_with_notice;

/**
 * Register this class if the the `Integrations_Hooks` if you have manageable options with the default options.
 * Extends this class if you need more or specific control.
 * When the integration have manageable options but not not the default options create your own hooks file and register it.
 *
 * Class Integration_Hooks
 * @package UnofficialConvertKit\Integrations\Admin
 *
 * @see Default_Integration
 */
class Default_Integration_Hooks implements Hooks {

	/**
	 * @var string the identifier of the integration
	 */
	private $id;

	public function __construct( string $identifier ) {
		$this->id = $identifier;
	}

	/**
	 * @inheritDoc
	 */
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
	 *
	 * @ignore
	 * @internal
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
	 * @param Default_Integration $integration
	 *
	 * @return array
	 */
	final public function sanitize_default( array $settings, Default_Integration $integration ): array {
		$uses_enabled = $integration->get_uses_enabled();
		$options      = $integration->get_options();

		require __DIR__ . '/../validators/class-default-integration-validator.php';

		if ( ! validate_with_notice( $settings, new Default_Integration_Validator( $uses_enabled ) ) ) {
			return $options;
		}

		$options['enabled'] = $uses_enabled && (bool) $settings['enabled'] ?? false;

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
		/**
		 * @see Default_Integration::$default_options
		 */
		$options['form-ids']       = $form_ids;
		$options['checkbox-label'] = (string) $settings['checkbox-label'];

		return $this->sanitize_options( $settings, $options, $integration );
	}

	/**
	 * Override this method when there are custom settings/options.
	 *
	 * @param array $settings form settings submitted by the user
	 * @param array $options default options sanitized
	 * @param Default_Integration $integration
	 *
	 * @return array
	 */
	public function sanitize_options( array $settings, array $options, Default_Integration $integration ): array {
		return $options;
	}
}
