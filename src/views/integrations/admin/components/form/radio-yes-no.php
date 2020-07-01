<?php

/**
 * Renders a yes and no radio input button
 *
 * @param string $name The input name
 * @param bool $yes_checked true the Yes radio button is checked. Otherwise the No button
 * @param string|null $help text to show in the help paragraph
 *
 * @internal
 */
return static function( string $name, bool $yes_checked, string $help = null ) {
	?>
	<label>
		<input
			type="radio"
			name="<?php echo $name; ?>"
			value="1"
			<?php echo $yes_checked ? 'checked' : null; ?>
		>
		<?php esc_html_e( 'Yes', 'unofficial-convertkit' ); ?>
	</label>
	&nbsp
	<label>
		<input
			type="radio"
			name="<?php echo $name; ?>"
			value="0"
			<?php echo $yes_checked ? null : 'checked'; ?>
		>
		<?php esc_html_e( 'No', 'unofficial-convertkit' ); ?>
	</label>
	<?php if ( ! empty( $help ) ) : ?>
		<p class="help">
			<?php echo $help; ?>
		</p>
	<?php endif; ?>
	<?php
};
