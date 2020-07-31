<?php

namespace UnofficialConvertKit\Admin;

use UnofficialConvertKit\Hooker;
use UnofficialConvertKit\Hooks;
use function UnofficialConvertKit\get_asset_src;

class Page_Hooks implements Hooks {

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

	/**
	 * @inheritDoc
	 */
	public function hook( Hooker $hooker ) {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_init', array( $this, 'register_pages' ) );
		add_filter( 'admin_title', array( $this, 'title' ), 10, 2 );

		if ( 'index' === $this->page_id ) {
			require __DIR__ . '/class-tabs-hooks.php';
			$hooker->add_hook( new Tabs_Hooks() );
		}
	}

	/**
	 * @param $admin_title
	 * @param $title
	 *
	 * @return mixed
	 */
	public function title( $admin_title, $title ) {
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

				$base(
					$this->page->get_breadcrumbs(),
					$this->page->get_callback()
				);
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

		if ( null !== $this->page ) {
			return;
		}

		//If page not exits redirect.
		if ( wp_redirect( admin_url( 'options-general.php?page=unofficial_convertkit' ) ) ) {
			die();
		}

		$this->page = 'index';
	}

	/**
	 * @return bool
	 */
	public function is_plugin_page():bool {
		global $plugin_page;

		return self::MENU_SLUG === $plugin_page;
	}
}
