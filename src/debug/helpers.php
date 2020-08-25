<?php

namespace UnofficialConvertKit\Debug;

/**
 * @param string $message
 */
function warning( string $message ) {
	log( $message, Log::WARNING );
}

/**
 * @param string $message
 */
function error( string $message ) {
	log( $message, Log::ERROR );
}

/**
 * @param string $message
 */
function debug( string $message ) {
	log( $message, Log::DEBUG );
}

/**
 * @param string $message
 */
function info( string $message ) {
	log( $message, Log::INFO );
}

/**
 * @param string $message
 * @param int $code
 */
function log( string $message, int $code ) {
	$log = new Log( $message, $code );

	add_action(
		'unofficial_convertkit_debug_log',
		static function( $add_log ) use ( $log ) {
			$add_log( $log );
		}
	);
}

