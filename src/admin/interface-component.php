<?php

namespace UnofficialConvertKit\Admin;

interface Component {

	/**
	 * @return string Unique to identify with for the program.
	 */
	public function get_identifier(): string;

	/**
	 * @return string Used to show in the title or on other places in the UI
	 */
	public function get_name(): string;

	/**
	 * @return callable The output of the component. Should return void.
	 */
	public function get_callback(): callable;

	/**
	 * Breadcrumbs which lead to this component.
	 *
	 * @return array[] {
	 *      @type string $url the admin url
	 *      @type string $breadcrumb the name of the breadcrumb
	 * }
	 */
	public function get_breadcrumbs(): array;
}
