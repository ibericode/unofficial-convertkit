<?php

use UnofficialConvertKit\Integrations\Default_Integration_Hooks;

/**
 * Is used for all the default integrations. to check.
 *
 * @param string $checkbox_label label text
 * @param array $label_attributes html attributes to add to label element
 *
 * @interal
 *
 * @see Default_Integration_Hooks
 */
return static function( string $checkbox_label, array $label_attributes = array() ) {
	array_walk(
		$label_attributes,
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
