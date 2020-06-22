<?php

namespace UnofficialConvertKit\Integration;

use DomainException;
use InvalidArgumentException;
use OutOfBoundsException;
use UnofficialConvertKit\Hooker;

class Integration_Repository {

	/**
	 * @var Integration[]
	 */
	private $integrations = array();

	/**
	 * @var Hooker
	 */
	private $hooker;

	public function __construct( Hooker $hooker ) {
		$this->hooker = $hooker;
		$this->add_integration( new Comment_Form_Integration() );

		if ( ! has_action( 'unofficial_convertkit_add_integrations' ) ) {
			return;
		}

		/**
		 * Register your integration.
		 * Create a class which implements the Integration interface and pass the instance to callable.
		 *
		 * @param callable takes instance of the Integration interface as first argument
		 *
		 * @return void
		 *
		 * @see Integration_Repository::add_integration()
		 * @see Integration
		 */
		do_action( 'unofficial_convertkit_add_integrations', array( $this, 'add_integration' ) );
	}

	/**
	 * @param string $identifier
	 *
	 * @return Integration
	 *
	 * @throws DomainException
	 */
	public function get_by_identifier( string $identifier ): Integration {
		if ( ! $this->exists( $identifier ) ) {
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

		if ( $this->exists( $id ) ) {
			throw new OutOfBoundsException(
				sprintf( 'Identifier of %s exists already', $id )
			);
		}

		$this->integrations[ $id ] = $integration;

		//Only hook when not is admin, is active and is available
		if ( ! is_admin() && $integration->is_active() && $integration->is_available() ) {
			$this->hooker->add_hook( $integration );
		}
	}
}
