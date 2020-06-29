<?php

namespace UnofficialConvertKit\Integrations;

use DomainException;
use InvalidArgumentException;
use OutOfBoundsException;
use UnexpectedValueException;
use UnofficialConvertKit\API\V3\Response_Exception;
use UnofficialConvertKit\Hooker;
use function UnofficialConvertKit\get_rest_api;

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

		if ( ! has_action( 'unofficial_convertkit_add_integration' ) ) {
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
		do_action( 'unofficial_convertkit_add_integration', array( $this, 'add_integration' ) );
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
	 * Check if an certain identifier is register.
	 *
	 * @param string $identifier unique name of the integration
	 *
	 * @return bool
	 *
	 * @see Integration::get_identifier()
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

		foreach ( $integration->actions() as $action ) {
			$this->add_action( $integration, $action );
		}

		//Only hook when is active and is available
		if ( $integration->is_active() && $integration->is_available() ) {
			$this->hooker->add_hook( $integration->get_hooks() );
		}
	}

	/**
	 * This function is like a middleware when the hook is fired this function is called.
	 * Calls your callable when the action is fired.
	 *
	 * @param Integration $integration
	 * @param callable $callable The callable
	 * @param array $args The arguments to pass to the callable
	 *
	 * @throws UnexpectedValueException in case if the value is not an string or email.
	 *
	 * @internal
	 *
	 * @see Integration::actions()
	 */
	public function notice( Integration $integration, callable $callable, array $args ) {
		$email = call_user_func_array( $callable, $args );

		if ( ! is_string( $email ) ) {
			throw new UnexpectedValueException(
				sprintf( 'Return value must be string. Returned %s', gettype( $email ) )
			);
		}

		/**
		 * The action is executed.
		 *
		 * @param string $email
		 * @param Integration $integration
		 */
		do_action( 'unofficial_convertkit_integrations_notice', $email, $integration );
	}

	/**
	 * Wrap's the callable in a function.
	 *
	 * @param Integration $integration
	 * @param array $action {
	 *      @type string $0 tag name of action
	 *      @type callable $1 callable for the add action
	 *      @type int $2 optional priority default 10
	 *      @type int $3 optional accepted_args default 1
	 * }
	 *
	 * @see add_action()
	 */
	private function add_action( Integration $integration, array $action ) {
		list($tag, $function) = $action;

		add_action(
			$tag,
			function() use ( $integration, $function ) {
				$this->notice( $integration, $function, func_get_args() );
			},
			$action[2] ?? 10,
			$action[3] ?? 1
		);
	}
}
