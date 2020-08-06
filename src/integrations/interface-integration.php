<?php

namespace UnofficialConvertKit\Integrations;

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
	 * The key `form-ids` is used to send.
	 *
	 * @return array The options used by the integration. You could add everything in this array.
	 */
	public function get_options(): array;

	/**
	 * The actions to call. like `comment_post`.
	 *
	 * @return array {
	 *      @type array $action {
	 *          @type string $0 tag name of action
	 *          @type callable $1 callable for the add action.
	 *                      The callable should return a string with a email address or array with an key named `email` and the value is a string.
	 *                      In case of invalid email the program will throw an `Response_Exception`.
	 *          @type int $2 priority default 10
	 *          @type int $3 accepted_args default 1
	 *      }
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Action_Reference#Actions_Run_During_a_Typical_Request
	 */
	public function actions(): array;

	/**
	 * Get the hooks objects.
	 * The hook method is only called when the `is_active` and `is_available` both return true.
	 * If you want to use this object for your hooks implement the `Hooks` interface on your integration and return $this.
	 * When your integration does not require additional hooks return null.
	 *
	 * @return Integration_Hooks|null The object with all your hooks
	 */
	public function get_hooks();
}
