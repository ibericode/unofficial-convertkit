<?php

namespace UnofficialConvertKit;

interface Hooks {

	/**
	 * Hook into WordPress. add the add_action and add_filters here.
	 *
	 * @return void
	 */
	public function hook();
}
