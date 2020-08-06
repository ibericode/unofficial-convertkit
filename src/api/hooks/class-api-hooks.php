<?php

namespace UnofficialConvertKit\API;

class API_Hooks {

	const VERSION = '1';

	const ROUTE_NAMESPACE = 'unofficial-convertkit/v' . self::VERSION;

	public function hook() {
		add_action( 'rest_api_init', array( $this, 'init_route' ) );
	}

	public function init_route() {
		$routes = static function() {
			return require dirname( __DIR__ ) . '/routes.php';
		};

		$routes = $this->build_routes( $routes() );

		foreach ( $routes as $route => $args ) {
			register_rest_route( self::ROUTE_NAMESPACE, $route, $args );
		}
	}

	/**
	 * Register all the routes define all the route.
	 * The namespace {@see ROUTE_NAMESPACE} constant is prefixed to every route.
	 *
	 * Define the route in the routes.php the key is the route name and passed as first argument to register_rest_route.
	 * The value is array passed as second argument to register_rest_route {@see register_rest_route}
	 * or pass a callable that return array with the parameters for register_rest_route
	 *
	 *
	 * @param array $routes
	 * @param string $route_prefix
	 *
	 * @return array
	 * @internal
	 * @ignore
	 */
	protected function build_routes( array $routes, string $route_prefix = '' ): array {
		$built = array();

		foreach ( $routes as $route => $args ) {
			if ( $route !== $route_prefix && ! empty( $route_prefix ) ) {
				$route = $route_prefix . $route;
			}

			if ( is_callable( $args ) ) {
				$args = $args();
			}

			//We known this is a route
			if ( strpos( key( $args ), '/' ) === 0 ) {
				$built += $this->build_routes( $args, $route );
				continue;
			}

			//Push only if arg is array
			$built[ $route ] = $args;
		}

		return $built;
	}
}
