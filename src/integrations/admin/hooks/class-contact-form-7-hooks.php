<?php

namespace UnofficialConvertKit\Integrations\Admin;

final class Contact_Form_7_Hooks extends Default_Integration_Hooks {
	/**
	 * Hooks
	 */
	public function hook() {
		parent::hook();

		add_action(
			'unofficial_convertkit_integration_admin_integration_form_above_contact_form_7',
			require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/integrations/admin/view-contact-form-7-help.php'
		);
	}
}
