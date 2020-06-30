<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use UnofficialConvertKit\Integrations\Integration;
use function UnofficialConvertKit\validate_with_notice;

class Comment_Form_Hooks extends Integration_Hooks {

	public function __construct() {
		parent::__construct( Comment_Form_Integration::IDENTIFIER );
	}

	/**
	 * @inheritDoc
	 */
	public function sanitize_options( array $settings, Integration $integration ): array {
		$options = $integration->get_options();

		require __DIR__ . '/../validators/class-comment-form-validator.php';

		if ( ! validate_with_notice( $settings, new Comment_Form_Validator() ) ) {
			return $options;
		}

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
