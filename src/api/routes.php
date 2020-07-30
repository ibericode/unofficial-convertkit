<?php

use UnofficialConvertKit\Forms\Forms_Controller;

/**
 * @see register_rest_route()
 *
 * @internal
 */
return array(
	'/forms' => static function() {

		require __DIR__ . '/controllers/class-forms-controller.php';
		$controller = new Forms_Controller();

		return array(
			'/' => array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $controller, 'index' ),
				'permission_callback' => array( $controller, 'authenticate' ),
			),
		);
	},
);
