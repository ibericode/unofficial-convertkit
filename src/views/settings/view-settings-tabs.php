<?php

namespace UnofficialConvertKit;

/**
 * The settings to manage the plugin
 *
 * @param string $active_tab the current name of the tab from the $_GET['tab'] parameter
 * @param callable $render_section The html of the tab. Has no arguments.
 *
 * @internal
 */
return function( string $active_tab, callable $render_section ) {

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
				// All the tabs
				$render_tab( __( 'General', 'unofficial-convertkit' ), 'general' );
				$render_tab( __( 'Integrations', 'unofficial-convertkit' ), 'integrations' );
			?>
		</h2>

		<?php $render_section(); ?>

	</div>
	<?php
};
?>
