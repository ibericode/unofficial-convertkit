<?php

namespace UnofficialConvertKit\Admin;

use function UnofficialConvertKit\get_asset_src;
use function UnofficialConvertKit\is_default_options;

class Page_Hooks {

	const MENU_SLUG = 'unofficial_convertkit';
	/**
	 * @var Page|null
	 */
	private $page;
	/**
	 * @var mixed|null
	 */
	private $page_id;

	public function __construct() {
		$this->page_id = $_GET['route'] ?? 'index';
	}

	public function hook() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_init', array( $this, 'register_pages' ), 20 );
		add_filter( 'admin_title', array( $this, 'title' ) );

		if ( 'index' === $this->page_id ) {
			require __DIR__ . '/class-tabs-hooks.php';
			( new Tabs_Hooks() )->hook();
		}
	}

	/**
	 * @param $admin_title
	 *
	 * @return mixed
	 */
	public function title( $admin_title ) {
		if ( ! $this->is_plugin_page() ) {
			return $admin_title;
		}

		return sprintf(
			/* translators: the name/title of the page. */
			__( '%s - Unofficial ConvertKit', 'unofficial-convertkit' ),
			$this->page->get_name()
		);
	}

	/**
	 * Register the page
	 *
	 * @internal
	 */
	public function register_page() {
		add_options_page(
			__( 'Settings', 'unofficial-convertkit' ),
			'Unofficial ConvertKit',
			'manage_options',
			self::MENU_SLUG,
			function() {
				wp_enqueue_style( 'unofficial-convertkit-admin', get_asset_src( 'css/admin.css' ), array(), UNOFFICIAL_CONVERTKIT_VERSION );

				$base = require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/views/admin/view-base-page.php';
				$base( $this->page );
			}
		);
	}

	/**
	 * Allow to add tabs and pages
	 */
	public function register_pages() {
		if ( ! $this->is_plugin_page() ) {
			return;
		}

		do_action(
			'unofficial_convertkit_admin_register_page',
			function( Page $page ) {
				if ( $page->get_identifier() !== $this->page_id ) {
					return;
				}

				$this->page = $page;
			}
		);

		$index = admin_url( 'options-general.php?page=unofficial_convertkit' );

		if ( is_default_options() && '/wp-admin/options-general.php?page=unofficial_convertkit' !== add_query_arg( null, null ) && wp_redirect( $index ) ) {
			die();
		}

		if ( null !== $this->page ) {
			return;
		}

		//If page not exits redirect. Note: some redirects can fail.
		if ( wp_redirect( $index ) ) {
			die();
		}

		$this->page = 'index';
	}

	/**
	 * @return bool
	 */
	public function is_plugin_page(): bool {
		global $plugin_page;

		return self::MENU_SLUG === $plugin_page;
	}
}
