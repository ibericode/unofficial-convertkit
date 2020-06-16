<?php

namespace UnofficialConvertKit;

class Integration_Controller {

	public function index() {
		//ToDo: add all the integrations
		$integrations = array();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/settings/view-integrations-page.php';
		$view( $integrations );
	}
}
