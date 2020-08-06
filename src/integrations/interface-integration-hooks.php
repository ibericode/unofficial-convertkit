<?php

namespace UnofficialConvertKit\Integrations;

interface Integration_Hooks {

	/**
	 * Registers the action and filter-hooks for this specific integration when it is active.
	 *
	 * @return void
	 */
	public function hook();
}
