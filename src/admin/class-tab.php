<?php

namespace UnofficialConvertKit\Admin;

class Tab {

	/**
	 * @var string
	 */
	private $identifier;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var callable
	 */
	private $callback;
	/**
	 * @var array
	 */
	private $breadcrumbs;
	/**
	 * @var int
	 */
	private $order;

	public function __construct( string $identifier, string $name, callable $callback, array $breadcrumbs = array(), int $order = 0 ) {
		$this->identifier  = $identifier;
		$this->name        = $name;
		$this->callback    = $callback;
		$this->breadcrumbs = $breadcrumbs;
		$this->order       = $order;
	}

	/**
	 * @return string
	 */
	public function get_identifier(): string {
		return $this->identifier;
	}

	/**
	 * @return string name of the page title
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * @return callable outputs the html
	 */
	public function get_callback(): callable {
		return $this->callback;
	}

	/**
	 * @return array[] {
	 *      @param string $url
	 *      @param string $breadcrumb
	 * }
	 */
	public function get_breadcrumbs(): array {
		return $this->breadcrumbs;
	}

	/**
	 * @return int
	 */
	public function get_order(): int {
		return $this->order;
	}
}
