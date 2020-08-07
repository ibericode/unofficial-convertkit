<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Admin\Page;
use UnofficialConvertKit\Admin\Page_Hooks;
use UnofficialConvertKit\Integrations\Default_Integration;

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
class Default_Integration_Hooks {
	/**
	 * @var Default_Integration
	 */
	public $default_integration;
	/**
	 * @var string
	 */
	private $url;

	public function __construct( Default_Integration $default_integration ) {
		$this->default_integration = $default_integration;
		$this->url                 = sprintf(
			'options-general.php?page=%s&route=integration&id=%s',
			Page_Hooks::MENU_SLUG,
			$this->default_integration->get_identifier()
		);
	}

	public function hook() {
		add_filter(
			'unofficial_convertkit_integrations_admin_menu_slug_' . $this->default_integration->get_identifier(),
			array( $this, 'page_url' )
		);

		add_filter(
			'unofficial_convertkit_integrations_admin_sanitize_' . $this->default_integration->get_identifier(),
			array( $this, 'sanitize_default' ),
			10,
			2
		);

		add_action(
			'unofficial_convertkit_integrations_admin_integration_page',
			array( $this, 'settings_page' )
		);
	}

	/**
	 * @param callable $register_page
	 */
	public function settings_page( callable $register_page ) {
		$id   = $this->default_integration->get_identifier();
		$name = $this->default_integration->get_name();

		$register_page(
			new Page(
				$id,
				$name,
				'__return_null',
				array(
					array(
						'url'        => admin_url( $this->page_url() ),
						'breadcrumb' => $name,
					),
				)
			)
		);
	}

	/**
	 * @return string
	 */
	public function page_url(): string {
		return $this->url;
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

		$enabled = $settings['enabled'] ?? false;

		if ( $uses_enabled && ! (bool) $enabled ) {
			$options['enabled'] = false;

			return $options;
		}

		if ( $uses_enabled && (bool) $enabled ) {
			$options['enabled'] = true;
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
