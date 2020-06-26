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

		//Sanitize to array
		foreach ( $settings['form-ids'] as $form_id => $checked ) {
			$checked = (bool) $checked;

			//Ignore: if the $key is not an integer
			if ( ! is_int( $form_id ) ) {
				continue;
			}

			$existing = array_search( $form_id, $options['form-ids'], true );

			//Non existing
			if ( false === $existing && $checked ) {
				$options['form-ids'][] = $form_id;
				continue;
			}

			//Existing unchecked
			if ( false !== $existing && ! $checked ) {
				unset( $options['form-ids'][ $existing ] );
			}

			//ignore all the other cases.
		}

		return $options;
	}
}
