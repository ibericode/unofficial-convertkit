<?php

namespace UnofficialConvertKit\Integrations;

use DomainException;
use OutOfBoundsException;
use UnexpectedValueException;

use function UnofficialConvertKit\Debug\log_warning;

class Integration_Repository {

	/**
	 * @var Integration[]
	 */
	private $integrations = array();

	/**
	 * @param string $identifier
	 *
	 * @return Integration
	 *
	 * @throws DomainException
	 */
	public function get_by_identifier( string $identifier ): Integration {
		if ( ! $this->exists( $identifier ) ) {
			throw new DomainException(
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
		return isset( $this->integrations[ $identifier ] );
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
	 * @param Integration[] $integrations
	 */
	public function add( Integration ...$integrations ) {
		foreach ( $integrations as $integration ) {
			$id = $integration->get_identifier();

			if ( $this->exists( $id ) ) {
				throw new OutOfBoundsException(
					sprintf( 'Identifier of %s exists already', $id )
				);
			}

			$this->integrations[ $id ] = $integration;

			/**
			 * For each integration that is added ths hook will run
			 *
			 * @param Integration $integration
			 */
			do_action( 'unofficial_convertkit_integration_added', $integration );

			// Only hook when integration is active (and available)
			if ( ! $integration->is_active() ) {
				continue;
			}

			foreach ( $integration->actions() as $action ) {
				$this->add_action( $integration, $action );
			}

			/** @var Integration_Hooks $hooks */
			$hooks = $integration->get_hooks();
			if ( null !== $hooks ) {
				$hooks->hook();
			}
		}
	}

	/**
	 * This function is like a middleware when the hook is fired this function is called.
	 * Calls your callable when the action is fired.
	 *
	 * @param Integration $integration the integration from the callable
	 * @param callable $callable The callable should return null, string or array
	 * @param array $args The arguments to pass to the callable
	 *
	 * @throws UnexpectedValueException in case if the value is not null, string or array.
	 *
	 * @internal
	 *
	 * @see Integration::actions()
	 */
	public function notice( Integration $integration, callable $callable, array $args ) {
		/** @var string|array|null $parameters */
		$parameters = call_user_func_array( $callable, $args );

		if ( ! ( is_string( $parameters ) || is_array( $parameters ) || is_null( $parameters ) ) ) {
			throw new UnexpectedValueException(
				sprintf( 'Return value must be null, string or array. Returned %s', gettype( $parameters ) )
			);
		}

		$id = $integration->get_identifier();

		if ( is_string( $parameters ) ) {
			//Convert the string to array.
			$parameters = array(
				'email' => $parameters,
			);
		}

		/**
		 * Filters the parameters for a specific integration
		 *
		 * @param null|array $parameters {
		 *      @type string $email
		 * }
		 * @param Integration $integration
		 * @param mixed $args the arguments of the callable
		 */
		$parameters = apply_filters( 'unofficial_convertkit_integrations_parameters_' . $id, $parameters, $integration, $args );

		/**
		 * Filters the parameters for each the integration
		 *
		 * @param null|array $parameters {
		 *      @type string $email
		 * }
		 * @param Integration $integration
		 * @param mixed $args the arguments of the callable
		 */
		$parameters = apply_filters( 'unofficial_convertkit_integrations_parameters', $parameters, $integration, $args );

		if ( empty( $parameters['email'] ) ) {
			log_warning(
				sprintf( '%s > unable to find the email.', $integration->get_name() )
			);
		}

		if ( empty( $parameters ) ) {
			return;
		}

		/**
		 * The action for an specific integration.
		 *
		 * @param array $parameters
		 * @param Integration $integration
		 * @param mixed $args the arguments of the callable
		 */
		do_action( 'unofficial_convertkit_integrations_notice_' . $integration->get_identifier(), $parameters, $integration, $args );

		/**
		 * The action for each integration.
		 *
		 * @param string $parameters
		 * @param Integration $integration
		 * @param mixed $args the arguments of the callable
		 */
		do_action( 'unofficial_convertkit_integrations_notice', $parameters, $integration, $args );
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
