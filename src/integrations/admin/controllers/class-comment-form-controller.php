<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Integration\Comment_Form_Integration;
use function UnofficialConvertKit\get_rest_api_client;

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
		$forms = get_rest_api_client()->lists_forms();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/integrations/view-comment-form-integration.php';

		$view( $this->integration, $forms );
	}
}
