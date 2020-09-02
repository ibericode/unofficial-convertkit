<?php

namespace UnofficialConvertKit\Debug;

/**
 * @param string $message
 */
function log_warning( string $message ) {
	log( $message, Log::WARNING );
}

/**
 * @param string $message
 */
function log_error( string $message ) {
	log( $message, Log::ERROR );
}

/**
 * @param string $message
 */
function log_debug( string $message ) {
	log( $message, Log::DEBUG );
}

/**
 * @param string $message
 */
function log_info( string $message ) {
	log( $message, Log::INFO );
}

/**
 * @param string $message
 * @param int $code
 */
function log( string $message, int $code ) {
	static $logger = null;

	if ( is_null( $logger ) ) {
		$logger = new Logger();
	}

	$logger->log( $message, $code );
}

