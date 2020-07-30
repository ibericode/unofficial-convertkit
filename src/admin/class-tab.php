<?php

namespace UnofficialConvertKit\Admin;

class Tab implements Component {

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

	public function __construct(
		string $identifier,
		string $name,
		callable $callback,
		array $breadcrumbs = array(),
		int $order = 0
	) {
		$this->identifier  = $identifier;
		$this->name        = $name;
		$this->callback    = $callback;
		$this->breadcrumbs = $breadcrumbs;
		$this->order       = $order;
	}

	/**
	 * @inheritDoc
	 */
	public function get_identifier(): string {
		return $this->identifier;
	}

	/**
	 * @inheritDoc
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * @inheritDoc
	 */
	public function get_callback(): callable {
		return $this->callback;
	}

	/**
	 * @inheritDoc
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
