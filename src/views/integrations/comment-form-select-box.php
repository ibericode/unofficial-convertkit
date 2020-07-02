<?php
/**
 * @param string $checkbox_label
 *
 * @interal
 */
return static function( string $checkbox_label ) {
	?>
		<label>
			<input
				type="checkbox"
				value="1"
				name="unofficial_convertkit_integrations_subscribe"
			>
			<?php echo $checkbox_label; ?>
		</label>
	<?php
};
