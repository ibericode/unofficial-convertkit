<?php

use UnofficialConvertKit\Integrations\Integration;

return static function( Integration $integration, stdClass $forms, bool $show_enabled = true ) {
	?>

	<?php if ( $show_enabled ) : ?>
		<tr>
			<?php call_user_func( require __DIR__ . '/../table/enable-row.php', $integration ); ?>
		</tr>
	<?php endif; ?>
	<tr>
		<?php
		call_user_func(
			require __DIR__ . '/../table/convertkit-forms-row.php',
			$forms->form ?? array(),
			$integration
		);
		?>
	</tr>
	<tr>
		<?php call_user_func( require __DIR__ . '/../table/checkbox-label-row.php', $integration ); ?>
	</tr>
	<?php
};
