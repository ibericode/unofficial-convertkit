<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Integrations\Integration_Repository;
use function UnofficialConvertKit\validate_with_notice;

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
		//ToDo: sort integrations add `is_available` and `is_active`
		$integrations = $this->integration_repository->get_all();

		$view = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/integrations/view-integrations-page.php';
		$view( $integrations );
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function save_enabled( $data ) {
		require __DIR__ . '/../validators/class-integration-enabled-validator.php';

		if ( ! validate_with_notice( $data, new Integration_Enabled_Validator() ) ) {
			//Prevent from executing to others
			remove_all_filters( 'sanitize_option_unofficial_convertkit_integration_comment_form' );
			return array();
		}

		$data['comment_form'] = (bool) $data['comment_form'];

		if ( ! $data['comment_form'] ) {
			remove_all_filters( 'sanitize_option_unofficial_convertkit_integration_comment_form' );
		}

		return $data;

	}
}
