<?php

namespace UnofficialConvertKit\Admin;

class Tabs_Hooks {
	/**
	 * @var Tab[]
	 */
	private $tabs = array();
	/**
	 * @var string
	 */
	private $tab_id;

	/**
	 * Tabs_Hooks constructor.
	 */
	public function __construct() {
		$this->tab_id = $_GET['tab'] ?? 'general';
	}

	public function hook() {
		add_action( 'admin_init', array( $this, 'register_tabs' ), 10 );
		add_action( 'unofficial_convertkit_admin_register_page', array( $this, 'register_page' ) );

		require __DIR__ . '/class-general-hooks.php';
		( new General_Hooks() )->hook();
	}

	/**
	 * @param callable $register
	 */
	public function register_page( callable $register ) {
		require __DIR__ . '/../controllers/class-tabs-controller.php';

		$current_tab = $this->tabs[ $this->tab_id ];

		$controller = new Tabs_Controller( $current_tab, $this->tabs );

		$register(
			new Page(
				'index',
				$current_tab->get_name(),
				array( $controller, 'index' ),
				$current_tab->get_breadcrumbs()
			)
		);
	}

	/**
	 * Register all the tabs
	 */
	public function register_tabs() {
		do_action(
			'unofficial_convertkit_admin_register_tab',
			function( Tab $tab ) {
				$this->tabs[ $tab->get_identifier() ] = $tab;
			}
		);
	}
}
