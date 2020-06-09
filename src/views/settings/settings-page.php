<?php

use UnofficialConvertKit\Settings_Controller;

/**
 * @internal
 *
 * @param array $tabs all the tabs to render
 * @param array $section the index $tabs of the active tab
 */
return function( array $tabs, array $section ) {
	?>
	<div class="wrap">
		<h1>Unofficial ConvertKit</h1>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $id => $tab ) : ?>
				<a
					href="<?php printf( '?page=%s&tab=%s', Settings_Controller::MENU_SLUG, $id ); ?>"
					class="nav-tab right <?php echo $tab['active'] ? 'nav-tab-active' : null; ?>"
				>
					<?php echo $tab['i18n']; ?>
				</a>
			<?php endforeach; ?>
		</h2>

		<?php $section['template'](); ?>

	</div>
	<?php
};
?>
