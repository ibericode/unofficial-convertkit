<?php
/**
 * @internal
 * @var array $tabs
 */

use UnofficialConvertKit\Settings_Controller;
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
</div>

