<?php

namespace UnofficialConvertKit\API\V3;

use RuntimeException;

/**
 * Base exception for all exceptions in this library.
 * Is thrown if there is no defined exception for the HTTP status code.
 *
 * @package UnofficialConvertKit\API\V3
 */
class Response_Exception extends RuntimeException {
}
