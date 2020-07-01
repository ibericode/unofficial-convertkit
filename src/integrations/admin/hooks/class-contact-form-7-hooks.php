<?php

namespace UnofficialConvertKit\Integrations\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;

final class Contact_Form_7_Hooks extends Default_Integration_Hooks {

	public function __construct() {
		parent::__construct( Contact_Form_7_Integration::IDENTIFIER );
	}

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		parent::hook( $hooker );

		add_action(
			'unofficial_convertkit_integration_admin_integration_form_above_contact_form_7',
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-contact-form-7-help.php'
		);
	}
}
