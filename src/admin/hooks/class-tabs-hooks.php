<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Tabs_Hooks implements Hooks {
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

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'admin_init', array( $this, 'register_tabs' ), 10 );
		add_action( 'unofficial_convertkit_admin_register_page', array( $this, 'register_page' ) );

		require __DIR__ . '/class-general-hooks.php';
		$hooker->add_hook( new General_Hooks() );
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
