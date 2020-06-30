<?php


use UnofficialConvertKit\Integrations\Integration;

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
			name="<?php printf( 'unofficial_convertkit_integrations[%s][checkbox-label]', $integration->get_identifier() ); ?>
			<?php if ( ! empty( $checkbox_label ) ) : ?>
				value="<?php echo $checkbox_label; ?>"
			<?php else : ?>
				value="<?php _e( 'Sign me up for the newsletter!', 'unofficial-convertkit' ); ?>"
			<?php endif; ?>
		>
	</td>
	<?php
};
