<?php

namespace UnofficialConvertKit;

use UnofficialConvertKit\Admin\Settings_Hooks;

/**
 * The settings to manage the plugin
 *
 * @param string $active_tab the current name of the tab from the $_GET['tab'] parameter
 *
 * @internal
 */
return function( string $active_tab ) {

	/**
	 * @param string $i18n the translatable name
	 * @param string $tab $the slug of the tab from $_GET['tab'] parameter
	 */
	$render_tab = function( string $i18n, string $tab ) use ( $active_tab ) {
		?>
		<a
				href="<?php printf( '?page=%s&tab=%s', Settings_Hooks::MENU_SLUG, $tab ); ?>"
				class="nav-tab right <?php echo $tab === $active_tab ? 'nav-tab-active' : null; ?>"
		>
			<?php echo $i18n; ?>
		</a>
		<?php
	}

	?>
	<div class="wrap">
		<h1>Unofficial ConvertKit</h1>
		<h2 class="nav-tab-wrapper">
			<?php
			/**
			 * Add all the tabs
			 *
			 * @param callable $render_tab small helper to render output a tab
			 */
			do_action( 'unofficial_convertkit_settings_tab', $render_tab );
			?>
		</h2>

		<?php
		if ( has_action( 'unofficial_convertkit_settings_tab_' . $active_tab ) ) {
			/**
			 * Show tab contents to the user
			 *
			 * @internal
			 */
			do_action( 'unofficial_convertkit_settings_tab_' . $active_tab );
		}
		?>

	</div>
	<?php
};
?>
