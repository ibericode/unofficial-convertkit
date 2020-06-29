<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\API\V3\Response_Exception;
use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use UnofficialConvertKit\Integrations\Admin\Integrations_Hooks as Admin_Integrations_Hooks;
use function UnofficialConvertKit\get_rest_api;

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

		add_action( 'unofficial_convertkit_integrations_notice', array( $this, 'action_fired' ), 10, 2 );
	}

	/**
	 * @param string $email
	 * @param Integration $integration
	 */
	public function action_fired( string $email, Integration $integration ) {
		$options = $integration->get_options();

		if ( ! key_exists( 'form-ids', $options ) ) {
			return;
		}

		foreach ( $options['form-ids'] as $form_id ) {
			try {
				get_rest_api()->add_form_subscriber(
					$form_id,
					array(
						'email' => $email,
					)
				);
			} catch ( Response_Exception $e ) {
				//silence
			}
		}
	}
}
