<?php

use UnofficialConvertKit\Integrations\Integration;

return static function( Integration $integration ) {
	$yes_no = require __DIR__ . '/../form/radio-yes-no.php';
	?>
	<th>
		<?php esc_html_e( 'Enabled', 'unofficial-convertkit' ); ?>
	</th>
	<td class="nowrap integration-toggles-wrap">
		<?php
		$yes_no(
			sprintf( 'unofficial_convertkit_integrations[%s][enabled]', $integration->get_identifier() ),
			$integration->is_active(),
			__( 'Enable the Comment Form integration? This will add a sign-up checkbox to the form.', 'unofficial-convertkit' )
		);
		?>
	</td>
	<?php
};
