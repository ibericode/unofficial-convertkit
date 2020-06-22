<?php

namespace UnofficialConvertKit;

use UnofficialConvertKit\Integration\Integration;

/**
 * View for
 *
 * @param Integration[] $integrations
 * @param array $menu_slugs
 *
 * @internal
 */
return function( array $integrations, array $menu_slugs ) {

	$row = function( Integration $integration, string $menu_slug = null ) {
		?>
		<tr>
			<td>
				<?php if ( empty( $url ) ) : ?>
					<?php echo $integration->get_name(); ?>
				<?php else : ?>
					<a href="<?php menu_page_url( $menu_slug ); ?>">
						<?php echo $integration->get_name(); ?>
					</a>
				<?php endif; ?>
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
					<?php $row( $integration, $menu_slug[ $integration->get_identifier() ] ?? '' ); ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php
};
