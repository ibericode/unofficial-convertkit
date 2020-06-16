<?php

namespace UnofficialConvertKit;

/**
 * The settings to manage the plugin
 *
 * @param array $tabs {
 *      The tabs defined
 *      @type bool $active
 *      @type string $i18n
 * }
 * @param string $section the index $tabs of the active tab
 *
 * @internal
 * @see Settings_Controller
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
				call_user_func( require __DIR__ . '/sections/view-section-general.php', get_options() );
				break;
			case 'integrations':
				call_user_func( require __DIR__ . '/sections/view-section-integrations.php' );
				break;

		}
		?>

	</div>
	<?php
};
?>
