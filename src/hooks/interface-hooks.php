<?php

namespace UnofficialConvertKit;

interface Hooks {

	/**
	 * Hook into WordPress. add the add_action and add_filters here.
	 *
	 * @param Hooker $hooker add hooks
	 *
	 * @return void
	 */
	public function hook( Hooker $hooker );

}
