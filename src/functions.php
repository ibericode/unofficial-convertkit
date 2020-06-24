<?php
/**
 * All the functions defined in this file you could rely on.
 */
namespace UnofficialConvertKit;

use UnofficialConvertKit\API\V3\REST_API;

/**
 * Factory function for the rest api class.
 *
 * @return REST_API
 * @since 1.0.0
 */
function get_rest_api(): REST_API {
	$options = get_options();

	return new REST_API( $options['api_key'], $options['api_secret'] );
}
