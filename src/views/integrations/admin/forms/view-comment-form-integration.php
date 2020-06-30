<?php

use UnofficialConvertKit\Integrations\Comment_Form_Integration;

return static function( Comment_Form_Integration $integration, stdClass $forms ) {
	?>
	<table class="form-table">
		<tbody>
			<?php call_user_func( require __DIR__ . '/../components/table/default-rows.php', $integration, $forms ); ?>
		</tbody>
	</table>
	<?php
};
