<?php

namespace UnofficialConvertKit;

/**
 * @internal
 */
return function() {
	?>
	<h1>First integration</h1>
	<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
		<input name="unofficial_convertkit_custom_integration[form]" value="text">
		<?php submit_button(); ?>
	</form>
	<?php
};
