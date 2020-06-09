<?php

/**
 * @internal
 */
return function() {

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

	do_settings_sections( 'unofficial_convertkit' );

	register_setting(
		'unofficial_convertkit',
		'unofficial_convertkit'
	);
}
?>
