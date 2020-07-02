<?php
/**
 * @param string $checkbox_label label text
 * @param array $attributes html attributes to add
 *
 * @interal
 */
return static function( string $checkbox_label, array $attributes = array() ) {

	array_walk(
		$attributes,
		static function ( string $value, string $key ) use ( &$html_attr ) {
			$html_attr .= ' ';
			$html_attr .= sprintf( '%s="%s"', $key, $value );
		}
	);
	?>
		<label<?php echo $html_attr ?? null; ?>>
			<input
				type="checkbox"
				value="1"
				name="unofficial_convertkit_integrations_subscribe"
			>
			<?php echo $checkbox_label; ?>
		</label>
	<?php
};
