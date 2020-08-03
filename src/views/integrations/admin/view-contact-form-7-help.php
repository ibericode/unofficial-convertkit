<?php

use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;

/**
 * @internal
 *
 * @see UnofficialConvertkit\Integrations\Admin\Contact_Form_7_Hooks
 */
return static function() {
	$input = sprintf( '<input type="text" size="%d" onfocus="this.select()" readonly="" value="[%s]">', strlen( Contact_Form_7_Integration::WPCF7_TAG ) * 0.8, Contact_Form_7_Integration::WPCF7_TAG )
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
