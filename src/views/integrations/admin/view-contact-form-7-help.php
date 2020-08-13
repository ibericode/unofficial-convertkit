<?php

use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;

/**
 * @see UnofficialConvertKit\Integrations\Admin\Contact_Form_7_Hooks
 * @internal
 */
return static function() {
	$shortcode = sprintf( '%s email-field:your-email', Contact_Form_7_Integration::WPCF7_TAG );
	$input     = sprintf( '<input type="text" size="%d" onfocus="this.select()" readonly="" value="[%s]">', round( strlen( $shortcode ) / 10 ) * 10, $shortcode )
	?>
	<p>
		<?php
			printf(
				/* translators: %s: input form tag  */
				esc_html__( 'To integrate with Contact Form 7, configure the settings below and then add %s to your CF7 form mark-up.', 'unofficial-convertkit' ),
				$input
			);
		?>
	</p>
	<?php
};
