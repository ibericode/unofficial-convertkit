<?php

namespace UnofficialConvertKit;

use UnofficialConvertKit\Integration\Integration;

/**
 * @param Integration $integration
 *
 * @internal
 */
return function( Integration $integration ) {
	?>
	<h1><?php echo $integration->get_name(); ?></h1>

	<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">

		<?php submit_button(); ?>
	</form>
	<?php
};
