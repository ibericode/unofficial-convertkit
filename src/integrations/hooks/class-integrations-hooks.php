<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integration\Admin\Integrations_Hooks as Admin_Integrations_Hooks;

class Integrations_Hooks implements Hooks {

	/**
	 * {@inheritDoc}
	 */
	public function hook( Hooker $hooker ) {
		//Todo: only add the hooks when needed.
		$integrations = new Integration_Repository( $hooker );
		$integrations->add_integration( new Comment_Form_Integration() );
		$integrations->add_integration( new Registration_Form_Integration() );
		$integrations->add_integration( new Contact_Form_7_Integration() );
		$integrations->add_integration( new Woo_Commerce_Integration() );

		if ( is_admin() ) {
			require __DIR__ . '/../admin/hooks/class-integrations-hooks.php';
			$hooker->add_hook( new Admin_Integrations_Hooks( $integrations ) );
		}
	}
}
