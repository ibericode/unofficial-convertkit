<?php
/**
 * Those function can change any time, don't rely on the functions declared in this file.
 *
 * @internal
 */
namespace UnofficialConvertKit;

/**
 * Get all the options registered
 *
 * @return array {
 *      @type string $api_key
 *      @type string $api_secret
 * }
 *
 * @since 1.0.0
 * @internal
 */
function get_options(): array {
	return \get_option( 'unofficial_convertkit_settings' );
}

/**
 * Get a single value of unofficial_convertkit_settings options
 *
 * @param string $key
 *
 * @return mixed|null
 *
 * @since 1.0.0
 * @internal
 */
function get_option( string $key ) {
	return get_options()[ $key ] ?? null;
}

/**
 * Get all the default options
 *
 * @return array
 * @since 1.0.0
 * @internal
 */
function get_default_options(): array {
	return array(
		'api_key'    => '',
		'api_secret' => '',
	);
}

/**
 * This will replace the first half of a string with "*" characters.
 *
 * @param string $string
 *
 * @return string
 *
 * @since 1.0.0
 * @internal
 */
function obfuscate_string( string $string ) {
	$length            = strlen( $string );
	$obfuscated_length = ceil( $length / 2 );
	$string            = str_repeat( '*', $obfuscated_length ) . substr( $string, $obfuscated_length );

	return $string;
}

/**
 * Check if the string is obfuscated
 *
 * @param string $string
 *
 * @return bool
 *
 * @see obfuscate_string()
 * @since 1.0.0
 * @internal
 */
function is_obfuscated_string( string $string ): bool {
	$length            = strlen( $string );
	$obfuscated_length = (int) ceil( $length / 2 );

	//Check asterisk length against the length needed for a valid obfuscated
	return strspn( $string, '*' ) === $obfuscated_length;
}


/**
 * Obfuscates email addresses in a string.
 *
 * @param $string String possibly containing email address
 * @return string
 */
function obfuscate_email_addresses( $string ) {
	return preg_replace_callback(
		'/([\w\.]{1,4})([\w\.]*)\@(\w{1,2})(\w*)\.(\w+)/',
		static function( $m ) {
			$one   = $m[1] . str_repeat( '*', strlen( $m[2] ) );
			$two   = $m[3] . str_repeat( '*', strlen( $m[4] ) );
			$three = $m[5];
			return sprintf( '%s@%s.%s', $one, $two, $three );
		},
		$string
	);
}


/**
 * @return bool Returns true if this is a request to admin-ajax.php, false otherwise.
 * @since 1.0.0
 * @internal
 */
function is_ajax_request() {
	return defined( 'DOING_AJAX' ) && DOING_AJAX;
}

/**
 * @param string $asset
 *
 * @return string
 * @since 1.0.0
 * @internal
 */
function get_asset_src( string $asset ): string {
	$relative_asset_dir = str_replace( UNOFFICIAL_CONVERTKIT_PLUGIN_DIR, '', UNOFFICIAL_CONVERTKIT_ASSETS_DIR );
	return plugins_url( sprintf( '%s/%s', $relative_asset_dir, $asset ), UNOFFICIAL_CONVERTKIT_PLUGIN_FILE );
}

/**
 * Checks if the options are the default options.
 *
 * @return bool
 * @since 1.0.0
 * @internal
 */
function is_default_options(): bool {
	return get_default_options() === get_options();
}
