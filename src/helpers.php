<?php
/**
 * Those function can change any time don't rely on the functions declared in this file.
 *
 * @internal
 */
namespace UnofficialConvertKit;

use UnexpectedValueException;

/**
 * Validate the data
 *
 * @param mixed $data
 * @param Validator_Interface $validator
 *
 * @return bool return true if no errors occurred other wise false.
 *
 * @since 0.0.0
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices
 */
function validate_with_notice( $data, Validator_Interface $validator ) {
	$errors = $validator->validate( $data );

	foreach ( (array) $errors as $error ) {
		if ( ! $error instanceof Validation_Error ) {
			throw new UnexpectedValueException(
				sprintf( '%s doesn\'t return array of instances of %s', get_class( $validator ), Validation_Error::class )
			);
		}

		$validator->notice( $error );
	}

	return count( $errors ) <= 0;
}

/**
 * Get all the options registered
 *
 * @return array {
 *      @type string $api_key
 *      @type string $api_secret
 * }
 *
 * @since 1.0.0
 */
function get_options(): array {
	return \get_option( 'unofficial_convertkit', get_default_options() );
}

/**
 * Get all the default options
 *
 * @return array
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
 * @return string
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
 */
function is_obfuscated_string( string $string ): bool {
	$length            = strlen( $string );
	$obfuscated_length = (int) ceil( $length / 2 );

	//Check asterisk against the length needed
	return strspn( $string, '*' ) === $obfuscated_length;
}
