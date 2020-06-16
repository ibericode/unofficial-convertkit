<?php

namespace UnofficialConvertKit;

/**
 * @param array $integrations
 *
 * @internal
 */
return function( array $integrations ) {
	call_user_func(
		require __DIR__ . '/view-settings-tabs.php',
		'integrations',
		function () {
			?>
			<h3>Integration's</h3>
			<table class="widefat striped">
				<thead>
				<tr>
					<td><?php _e( 'Name', 'unofficial-convertkit' ); ?></td>
					<td><?php _e( 'Description', 'unofficial-convertkit' ); ?></td>
					<td><?php _e( 'Status', 'unofficial-convertkit' ); ?></td>
				</tr>
				</thead>
				<tbody>


				</tbody>
			</table>
			<?php
		}
	);
};
