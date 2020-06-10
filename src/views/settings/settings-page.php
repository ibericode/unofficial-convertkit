<?php

use UnofficialConvertKit\Settings_Controller;

/**
 * The settings to manage the plugin
 *
 * @internal
 *
 * @param array $tabs all the tabs to render
 * @param string $section the index $tabs of the active tab
 */
return function( array $tabs, string $section ) {
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

		<?php
		switch ( $section ) {
			case 'general':
				$template = require __DIR__ . '/section/section-general.php';
				$template();
				break;
		}
		?>

	</div>
	<?php
};
?>

