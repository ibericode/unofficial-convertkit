<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use function UnofficialConvertKit\validate_with_notice;

class Comment_Form_Hooks implements Hooks {

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		add_filter(
			'unofficial_convertkit_integrations_admin_menu_slug_' . Comment_Form_Integration::IDENTIFIER,
			array( $this, 'get_settings_page_slug' )
		);

		add_filter(
			'unofficial_convertkit_integrations_admin_sanitize_' . Comment_Form_Integration::IDENTIFIER,
			array( $this, 'validate_settings' ),
			10,
			2
		);

		add_action(
			'unofficial_convertkit_integrations_admin_integration_form_' . Comment_Form_Integration::IDENTIFIER,
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/forms/view-comment-form-integration.php',
			10,
			2
		);
	}

	/**
	 * Get the menu slug of the settings pages
	 *
	 * @ignore
	 * @internal
	 */
	public function get_settings_page_slug() {
		return sprintf(
			'admin.php?page=%s&id=%s',
			Integrations_Hooks::MENU_SLUG,
			Comment_Form_Integration::IDENTIFIER
		);
	}

	/**
	 * @param array $settings
	 * @param Comment_Form_Integration $integration
	 */
	public function validate_settings( array $settings, Comment_Form_Integration $integration ) {
		$options = $integration->get_options();

		require __DIR__ . '/../validators/class-comment-form-validator.php';

		if ( ! validate_with_notice( $settings, new Comment_Form_Validator() ) ) {
			return $options;
		}

		remove_filter( 'sanitize_option_unofficial_convertkit_integrations_comment_form', array( $this, 'save' ) );

		$options['enabled'] = (bool) $settings['enabled'];

		if ( ! $options['enabled'] ) {
			//Don't execute the rest not important, because it is disabled
			return $options;
		}

		$form_ids = array();

		//Sanitize to array
		foreach ( $settings['form-ids'] ?? array() as $form_id ) {
			$form_id = intval( $form_id );

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

		return $options;
	}
}
