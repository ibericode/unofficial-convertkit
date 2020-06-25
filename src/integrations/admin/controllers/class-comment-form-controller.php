<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Integration\Comment_Form_Integration;
use function UnofficialConvertKit\get_rest_api;
use function UnofficialConvertKit\validate_with_notice;

class Comment_Form_Controller {

	/**
	 * @var Comment_Form_Integration
	 */
	private $integration;

	private $default = array(
		'form-ids' => array(),
	);

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

		require __DIR__ . '/../validators/class-comment-form-validator.php';

		if ( ! validate_with_notice( $settings, new Comment_Form_Validator() ) ) {
			return array();
		}

		remove_filter( 'sanitize_option_unofficial_convertkit_integration_comment_form', array( $this, 'save' ) );

		return $settings;
	}
}
