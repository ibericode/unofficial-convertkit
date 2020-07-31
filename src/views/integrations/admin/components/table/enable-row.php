<?php

use UnofficialConvertKit\Integrations\Integration;

/**
 * The row to enable the integration
 *
 * @param Integration $integration
 * @param bool $active
 *
 * @internal
 */
return static function( Integration $integration, bool $active ) {
	$yes_no = require __DIR__ . '/../form/radio-yes-no.php';
	?>
	<th>
		<?php esc_html_e( 'Activate', 'unofficial-convertkit' ); ?>
	</th>
	<td class="nowrap integration-toggles-wrap">
		<?php
		$yes_no(
			sprintf( 'unofficial_convertkit_integrations[%s][enabled]', $integration->get_identifier() ),
			$active,
			sprintf(
				/* translators: %s the name of the integration */
				__( 'Activate the %s integration? This will add a sign-up checkbox to the form.', 'unofficial-convertkit' ),
				$integration->get_name()
			)
		);
		?>
	</td>
	<?php
};
