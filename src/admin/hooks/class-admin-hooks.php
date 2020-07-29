<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;

class Admin_Hooks implements Hooks {

	const MENU_SLUG = 'unofficial_converkit';

	/**
	 * @var Tab[]
	 */
	private $tabs = array();

	/**
	 * @var Page[]
	 */
	private $pages = array();

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'admin_init', array( $this, 'register_components' ) );
		add_action( 'admin_menu', array( $this, 'register_page' ) );

		require __DIR__ . '/class-general-hooks.php';
		$hooker->add_hook( new General_Hooks() );
	}

	/**
	 * Register the page
	 *
	 * @internal
	 */
	public function register_page() {
		add_options_page(
			__( 'Settings', 'unofficial-convertkit' ),
			'Unofficial ConvertKit',
			'manage_options',
			self::MENU_SLUG,
			array( $this, 'dispatch' )
		);
	}

	/**
	 * Allow to add tabs and pages
	 */
	public function register_components() {
		do_action( 'unofficial_convertkit_admin_register_tab', array( $this, 'add_tab' ) );
		do_action( 'unofficial_convertkit_admin_register_page', array( $this, 'add_page' ) );
	}

	/**
	 * @param Page $page
	 */
	public function add_page( Page $page ) {
		$this->pages[ $page->get_identifier() ] = $page;
	}

	/**
	 * @param Tab $tab
	 */
	public function add_tab( Tab $tab ) {
		$this->tabs[ $tab->get_identifier() ] = $tab;
	}

	/**
	 * Detriments which action must be executed to show the correct admin page.
	 */
	public function dispatch() {
		$route = $_GET['route'] ?? '';

		if ( ! empty( $route ) && isset( $this->pages[ $route ] ) ) {
			$page        = $this->pages[ $route ];
			$callable    = $page->get_callback();
			$breadcrumbs = $page->get_breadcrumbs();
		} else {
			$active_tab = 'general';

			if ( ! empty( $_GET['tab'] ) && ! empty( $this->tabs[ $_GET['tab'] ] ) ) {
				$active_tab = $_GET['tab'];
			}
			$tabs = $this->tabs;

			usort(
				$tabs,
				static function ( Tab $a, Tab $b ) {
					if ( $a->get_order() === $b->get_order() ) {
						return 0;
					}

					return $a->get_order() > $b->get_order() ? +1 : -1;
				}
			);

			$tab         = $this->tabs[ $active_tab ];
			$breadcrumbs = $tab->get_breadcrumbs();
			$callable    = static function() use ( $tab, $tabs ) {
				$tabs_page = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-tabs-page.php';
				$tabs_page( $tab, $tabs );
			};
		}

		$base = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-base-page.php';
		$base( $breadcrumbs, $callable );
	}
}
