<?php

namespace UnofficialConvertKit\Integration;

use DomainException;
use InvalidArgumentException;
use OutOfBoundsException;

class Integration_Repository {

	/**
	 * @var Integration[]
	 */
	private $integrations = array();

	/**
	 * Integration_Repository constructor.
	 *
	 * @param Integration[] $integrations
	 */
	public function __construct( array $integrations = array() ) {
		foreach ( $integrations as $integration ) {
			$this->add_integration( $integration );
		}
	}

	/**
	 * @param string $identifier
	 *
	 * @return Integration
	 *
	 * @throws DomainException
	 */
	public function get_by_identifier( string $identifier ): Integration {
		if ( ! key_exists( $identifier, $this->integrations ) ) {
			throw new InvalidArgumentException(
				sprintf( 'Given identifier %s doesn\'t exists', $identifier )
			);
		}

		return $this->integrations[ $identifier ];
	}


	/**
	 * @param string $identifier
	 *
	 * @return bool
	 */
	public function exists( string $identifier ): bool {
		return key_exists( $identifier, $this->integrations );
	}

	/**
	 * @return Integration[] All the integrations that exists
	 */
	public function get_all(): array {
		return array_values( $this->integrations );
	}

	/**
	 * Add integration manually, mostly not needed to call this function you should use the action `unofficial_convertkit_register_integration`
	 *
	 * @param Integration $integration
	 *
	 * @throws OutOfBoundsException
	 */
	public function add_integration( Integration $integration ) {
		$id = $integration->get_identifier();

		if ( key_exists( $id, $this->integrations ) ) {
			throw new OutOfBoundsException(
				sprintf( 'Identifier of %s exists already', $id )
			);
		}

		$this->integrations[ $id ] = $integration;
	}
}
