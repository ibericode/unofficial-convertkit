<?php

namespace UnofficialConvertKit\Admin;

use stdClass;
use UnofficialConvertKit\API\V3\Response_Exception;
use UnofficialConvertKit\API\V3\REST_API;

use UnofficialConvertKit\API\V3\Unauthorized_Exception;

class Connection_Status {

	const NEUTRAL       = 0;
	const CONNECTED     = 1;
	const NOT_CONNECTED = -1;

	/**
	 * @var int
	 */
	public $status = self::NEUTRAL;

	/**
	 * @var stdClass|false
	 */
	private $account;

	/**
	 * @var string
	 */
	public $message = '';

	/**
	 * @var REST_API
	 */
	private $api;

	public function __construct( string $api_key, string $api_secret ) {

		if ( '' === $api_key && '' === $api_secret ) {
			return;
		}

		$this->api = new REST_API( $api_key, $api_secret );

		try {
			if ( ! $this->is_valid_api_key() ) {
				$this->status  = self::NOT_CONNECTED;
				$this->message = __( 'Your API key seems invalid.', 'unoffical-convertkit' );
				return;
			}

			if ( ! $this->is_valid_api_secret() ) {
				$this->status  = self::NOT_CONNECTED;
				$this->message = __( 'Your API secret seems invalid.', 'unoffical-convertkit' );
				return;
			}

			$this->status = self::CONNECTED;
		} catch ( Response_Exception $e ) {
			$this->status  = self::NOT_CONNECTED;
			$this->message = $e->getMessage();
		}
	}

	/**
	 * @return bool
	 */
	public function is_valid_api_secret(): bool {
		if ( is_null( $this->account ) ) {
			$this->get_account();
		}

		return false !== $this->account;
	}

	/**
	 * @return bool
	 *
	 * @throws Response_Exception
	 */
	public function is_valid_api_key(): bool {
		try {
			$this->api->list_forms();
		} catch ( Unauthorized_Exception $e ) {
			return false;
		} catch ( Response_Exception $e ) {
			throw $e;
		}

		return true;
	}

	/**
	 * @return stdClass|false false in case of an Response exception error
	 *
	 * @throws Response_Exception
	 */
	public function get_account() {
		if ( ! is_null( $this->account ) ) {
			return $this->account;
		}

		try {
			$this->account = $this->api->account();
		} catch ( Unauthorized_Exception $e ) {
			return false;
		} catch ( Response_Exception $e ) {
			throw $e;
		}

		return $this->account;
	}
}
