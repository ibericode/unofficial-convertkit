<?php

namespace UnofficialConvertKit\Integration;

use UnofficialConvertKit\Hooks;

interface Integration extends Hooks {

	/**
	 * @return string unique name a machine name like: `hello_world`
	 */
	public function get_identifier(): string;

	/**
	 * @return string translate able name
	 */
	public function get_name(): string;

	/**
	 * @return string the description about the integration
	 */
	public function get_description(): string;

	/**
	 * @return bool true if the integration is available other wise false
	 */
	public function is_available(): bool;

	/**
	 * @return bool true if the integration is used by the user
	 */
	public function is_active(): bool;

	/**
	 * @return array The options used by the integration
	 */
	public function get_options(): array;
}
