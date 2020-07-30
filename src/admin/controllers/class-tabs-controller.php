<?php

namespace UnofficialConvertKit\Admin;

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
		$tabs = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-tabs-page.php';

		usort(
			$this->tabs,
			static function ( Tab $a, Tab $b ) {
				if ( $a->get_order() === $b->get_order() ) {
					return 0;
				}

				return $a->get_order() > $b->get_order() ? +1 : -1;
			}
		);

		$tabs( $this->tab, $this->tabs );
	}
}
