<?php

use UnofficialConvertKit\Integrations\Integration;

/**
 * The text input for the checkbox label
 *
 * @param Integration $integration
 *
 * @internal
 */
return static function( Integration $integration ) {
	$checkbox_label = $integration->get_options()['checkbox-label'];

	?>
	<th>
		<label for="unofficial-convertkit-checkbox-label">
			<?php esc_html_e( 'Checkbox label text', 'unofficial-convertkit' ); ?>
		</label>
	</th>
	<td>
		<input
			type="text"
			class="widefat"
			id="unofficial-convertkit-checkbox-label"
			name="<?php printf( 'unofficial_convertkit_integrations[%s][checkbox-label]', $integration->get_identifier() ); ?>"

				value="<?php echo $checkbox_label; ?>"

		>
	</td>
	<?php
};
