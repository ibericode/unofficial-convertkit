<?php

/**
 * @param string $uid The uid of the form from the request
 * @param string $embed_js The full url to the embed js
 *
 * @internal
 */
return static function( string $uid, string $embed_js ) {
	?>
		<script async data-uid="<?php echo $uid; ?>" src="<?php echo $embed_js; ?>"></script>
	<?php
};
