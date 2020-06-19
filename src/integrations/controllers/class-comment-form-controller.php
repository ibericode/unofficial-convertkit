<?php

namespace UnofficialConvertKit\Integration;

class Comment_Form_Controller {

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	public function __construct() {
	}

	public function index( Integration $comment_form ) {

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/view-comment-form-integration.php';

		$view( $comment_form );
	}
}
