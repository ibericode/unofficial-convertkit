<?php

use UnofficialConvertKit\Admin\Page_Hooks;
use UnofficialConvertKit\Admin\Tab;

/**
 * The settings to manage the plugin
 *
 * @param Tab $active_tab the current name of the tab from the $_GET['tab'] parameter
 *
 * @param Tab[] $tabs
 *
 * @internal
 */
return static function( Tab $active_tab, array $tabs ) {
	?>
	<h1>Unofficial ConvertKit</h1>
	<h2 class="nav-tab-wrapper">
		<?php foreach ( $tabs as $tab ) : ?>
			<a
				href="<?php printf( '?page=%s&tab=%s', Page_Hooks::MENU_SLUG, $tab->get_identifier() ); ?>"
				class="nav-tab right <?php echo $tab->get_identifier() === $active_tab->get_identifier() ? 'nav-tab-active' : null; ?>"
				role="button"
			>
				<?php echo $tab->get_name(); ?>
			</a>

		<?php endforeach; ?>
	</h2>

	<?php $active_tab->get_callback()(); ?>
	<?php
};
?>
