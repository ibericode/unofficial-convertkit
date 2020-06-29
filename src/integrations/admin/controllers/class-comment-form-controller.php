<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Integrations\Comment_Form_Integration;
use function UnofficialConvertKit\get_rest_api;
use function UnofficialConvertKit\validate_with_notice;

class Comment_Form_Controller {

	/**
	 * @var Comment_Form_Integration
	 */
	private $integration;

	public function __construct( Comment_Form_Integration $integration ) {
		$this->integration = $integration;
	}

	public function index() {
		//Todo: caching request
		$forms = get_rest_api()->lists_forms();

		//Todo: add user text
		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/integrations/view-comment-form-integration.php';

		$view( $this->integration, $forms );
	}

	/**
	 * Save the settings of integration form
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function save( $settings ) {
		$options = $this->integration->get_options();

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
