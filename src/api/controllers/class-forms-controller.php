<?php

namespace UnofficialConvertKit\Forms;

use stdClass;
use function UnofficialConvertKit\get_rest_api;

class Forms_Controller {

	/**
	 * @return bool
	 */
	public function authenticate(): bool {
		return current_user_can( 'edit_posts' );
	}

	/**
	 * @return stdClass
	 */
	public function index(): stdClass {
		//ToDo: cache the request
		return get_rest_api()->list_forms();
	}
}
