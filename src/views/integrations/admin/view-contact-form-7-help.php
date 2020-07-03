<?php

use UnofficialConvertKit\Integrations\Contact_Form_7_Integration;

/**
 * @internal
 *
 * @see UnofficialConvertkit\Integrations\Admin\Contact_Form_7_Hooks
 */
return static function() {
	$input = sprintf( '<input type="text" size="29" onfocus="this.select()" readonly="" value="[%s]">', Contact_Form_7_Integration::WPCF7_TAG )
	?>
	<p>
	<?php
		printf(
			/* translators: %s: input form tag  */
			esc_html__( 'To integrate with Contact Form 7, configure the settings below and then add %s to your CF7 form mark-up.', 'unofficial-converkit' ),
			$input
		);
	?>
		</p>
	<?php
};
