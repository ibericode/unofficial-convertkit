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
 * @param array $settings {
 *      The options from the database
 *      @type string $api_key
 *      @type string $api_secret
 * }
 *
 * @internal
 *
 */
return function( array $tabs, string $section, array $settings ) {
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
				$template( $settings );
				break;
		}
		?>

	</div>
	<?php
};
?>
