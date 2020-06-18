<?php

namespace UnofficialConvertKit\Integration;

/**
 * Class Integration_Controller
 * @package UnofficialConvertKit
 *
 * Controller for integrations settings.
 */
class Integration_Controller {

	public function __construct() {

	}

	public function index() {
		//ToDo: add all the integrations
		$integrations = array();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/view-integrations-page.php';
		$view( $integrations );
	}
}
