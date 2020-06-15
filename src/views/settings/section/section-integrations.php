<?php

namespace UnofficialConvertKit;

/**
 * @internal
 */
return function() {
	//ToDo: implement view
	?>
		<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
			<table class="widefat striped">
				<thead>
					<tr>
						<td><?php _e( 'Name', 'unofficial-convertkit' ); ?></td>
						<td><?php _e( 'Description', 'unofficial-convertkit' ); ?></td>
						<td><?php _e( 'Status', 'unofficial-convertkit' ); ?></td>
					</tr>
				</thead>
			</table>
		<form/>
	<?php
};
