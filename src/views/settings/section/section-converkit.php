<?php

/**
 * @internal
 */
return function() {

	register_setting(
		'unofficial_convertkit',
		'unofficial_convertkit'
	);

	add_settings_section(
		'unofficial_convertkit',
		__( 'Connect to ConvertKit', 'unofficial-convertkit' ),
		function() {
			//TODO: add proper text for the user
			?>
				<p><?php esc_html_e( 'Todo: add proper text for the user', 'unofficial-convertkit' ); ?></p>
			<?php
		},
		'unofficial_convertkit'
	);

	add_settings_field(
		'test_field',
		'Test field',
		function() {
			?>
				<input type="text" class="regular-text code" id="api-key">
			<?php
		},
		'unofficial_convertkit',
		'unofficial_convertkit'
	);

	?>

	<form method="post" action="options.php">
	<?php
		do_settings_sections( 'unofficial_convertkit' );
		settings_fields( 'unofficial_convertkit' );
	?>
	</form>
	<?php
}
?>
