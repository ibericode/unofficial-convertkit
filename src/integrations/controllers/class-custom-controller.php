<?php

namespace UnofficialConvertKit\Integration;

class Custom_Controller {

	public function index() {
		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/view-custom-integration.php';
		$view();
	}

	public function save() {

	}
}
