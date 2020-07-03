<?php

/**
 * @internal
 */
return static function() {
	?>
	<p>
	<?php
		printf(
			/* translators: %s: input form markup  */
			esc_html__( 'To integrate with Contact Form 7, configure the settings below and then add %s to your CF7 form mark-up.', 'unofficial-converkit' ),
			'<input type="text" size="29" onfocus="this.select()" readonly="" value="[unofficial_convertkit_checkbox]">'
		);
	?>
		</p>
	<?php
};
