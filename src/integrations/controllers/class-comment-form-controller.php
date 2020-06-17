<?php

namespace UnofficialConvertKit\Integration;

class Comment_Form_Controller {

	public function index() {
		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/view-comment-form-integration.php';

		$view();
	}
}
