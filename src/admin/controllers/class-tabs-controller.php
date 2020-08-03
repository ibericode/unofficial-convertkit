<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\is_default_options;

class Tabs_Controller {

	/**
	 * @var Tab[]
	 */
	private $tabs;

	/**
	 * @var Tab the active tab.
	 */
	private $tab;

	/**
	 * Tabs_Controller constructor.
	 *
	 * @param Tab $tab
	 * @param array $tabs
	 */
	public function __construct( Tab $tab, array $tabs ) {
		$this->tabs = $tabs;
		$this->tab  = $tab;
	}

	/**
	 * Order the tabs.
	 */
	public function index() {
		if ( is_default_options() ) {
			$this->tabs['general']->get_callback()();

			return;
		}

		usort(
			$this->tabs,
			static function ( Tab $a, Tab $b ) {
				if ( $a->get_order() === $b->get_order() ) {
					return 0;
				}

				return $a->get_order() > $b->get_order() ? +1 : -1;
			}
		);

		$tabs = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-tabs-page.php';
		$tabs( $this->tab, $this->tabs );
	}
}
