<?php

namespace UnofficialConvertKit\Forms;

use Exception;
use stdClass;
use WP_REST_Request;
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

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return array
	 */
	public function render( $request ): array {
		$id       = $request->get_url_params()['id'];
		$response = array(
			'rendered' => '',
		);

		try {
			$form = get_rest_api()->list_form( $id );
		} catch ( Exception $e ) {
			return $response;
		}

		$response['rendered'] = wp_remote_retrieve_body(
			wp_remote_request(
				$form->embed_url
			)
		);

		return $response;
	}
}
