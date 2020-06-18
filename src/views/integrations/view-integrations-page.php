<?php

namespace UnofficialConvertKit;

use UnofficialConvertKit\Integration\Integration;

/**
 * View for
 *
 * @param Integration[] $integrations
 *
 * @internal
 */
return function( array $integrations ) {

	$row = function( Integration $integration ) {
		?>
		<tr>
			<td>
				<?php echo $integration->get_name(); ?>
			</td>
			<td class="desc">
				<?php echo $integration->get_description(); ?>
			</td>
			<td>
				<?php if ( $integration->is_active() ) : ?>
					<?php esc_html_e( 'Enabled', 'unofficial-convertkit' ); ?> 
				<?php else : ?>
					<?php esc_html_e( 'Enabled', 'unofficial-convertkit' ); ?>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	};

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
				<?php foreach ( $integrations as $integration ) : ?>
					<?php $row( $integration ); ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php
};
