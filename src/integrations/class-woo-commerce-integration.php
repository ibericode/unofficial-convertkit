<?php

namespace UnofficialConvertKit\Integrations;

use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\is_active_plugin;

class Woo_Commerce_Integration implements Integration {

	const IDENTIFIER = 'woo_commerce';

	/**
	 * @inheritDoc
	 */
	public function get_identifier(): string {
		return self::IDENTIFIER;
	}

	/**
	 * @inheritDoc
	 */
	public function get_name(): string {
		return 'Woo Commerce Checkout';
	}

	/**
	 * @inheritDoc
	 */
	public function get_description(): string {
		return __( 'Subscribes people from WooCommerce\'s checkout form.', 'unofficial-converkit' );
	}

	/**
	 * @inheritDoc
	 */
	public function is_available(): bool {
		// TODO: Implement is_available() method.
		return defined( 'WC_PLUGIN_BASENAME' ) && is_active_plugin( WC_PLUGIN_BASENAME );
	}

	/**
	 * @inheritDoc
	 */
	public function is_active(): bool {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function get_options(): array {
		return array(
			'forms-id' => array( 1441335 ),
		);
	}

	/**
	 * @inheritDoc
	 */
	public function actions(): array {
		//TODO: find the hooks of woo commerce
		return array();
	}

	/**
	 * @inheritDoc
	 */
	public function get_hooks(): Hooks {
		require __DIR__ . '/hooks/class-woo-commerce-hooks.php';

		return new Woo_Commerce_Hooks();
	}
}
