<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooks;

interface Integration {
	/**
	 * Used to identifies the integration used mostly used for hooks.
	 *
	 * @return string unique name a machine name like: `hello_world`
	 */
	public function get_identifier(): string;

	/**
	 * The name of the integration shown to user in the overview page.
	 *
	 * @return string translate able name
	 */
	public function get_name(): string;

	/**
	 * The description is used in the integrations overview.
	 * Give a clear description for the user to know where the integration is used for.
	 *
	 * @return string the description about the integration
	 */
	public function get_description(): string;

	/**
	 * Some integrations depend on some plugins an must be installed before the integration is available.
	 * The integration is still shown the overview page `integrations` but blurred out.
	 *
	 * @return bool true if the integration is available other wise false
	 */
	public function is_available(): bool;

	/**
	 * The program must know when
	 *
	 * @return bool true if the integration is used by the user
	 */
	public function is_active(): bool;

	/**
	 * All the specific options for the integration.
	 * Most like those are set in a settings page.
	 *
	 * @return array The options used by the integration
	 */
	public function get_options(): array;

	/**
	 * Get the hooks objects.
	 * The hook method is only called when the `is_active` and `is_available` both return true.
	 * If you want to use this object for your hooks implement the `Hooks` interface on your integration and return $this.
	 *
	 * @return Hooks The object with all your hooks
	 */
	public function get_hooks(): Hooks;
}
