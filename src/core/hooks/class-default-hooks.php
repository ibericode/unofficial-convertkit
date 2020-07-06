<?php

namespace UnofficialConvertKit;

class Default_Hooks implements Hooks {

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_filter( 'default_option_unofficial_convertkit_settings', array( $this, 'set_default_options' ) );
	}

	/**
	 * @return array|string[]
	 */
	public function set_default_options(): array {
		return get_default_options();
	}
}
