<?php

namespace UnofficialConvertKit\Integration\Admin;

use UnofficialConvertKit\Integration\Integration_Repository;

/**
 * Class Integration_Controller
 * @package UnofficialConvertKit
 *
 * Controller for integrations settings.
 */
class Integration_Controller {

	/**
	 * @var Integration_Repository
	 */
	private $integration_repository;

	/**
	 * @var array
	 */
	private $menu_slugs;

	public function __construct(
		Integration_Repository $integration_repository,
		array $menu_slugs
	) {
		$this->integration_repository = $integration_repository;
		$this->menu_slugs             = $menu_slugs;
	}

	public function index() {
		//ToDo: add all the integrations
		$integrations = $this->integration_repository->get_all();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/integrations/view-integrations-page.php';
		$view( $integrations );
	}
}
