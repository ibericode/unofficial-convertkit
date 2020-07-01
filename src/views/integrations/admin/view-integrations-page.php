<?php

use UnofficialConvertKit\Integrations\Integration;

/**
 * View for
 *
 * @param Integration[] $integrations
 *
 * @internal
 */
return static function( array $integrations ) {

	$row = static function( Integration $integration, string $menu_slug ) {
		?>
		<tr>
			<td>
				<?php if ( empty( $menu_slug ) ) : ?>
					<?php echo $integration->get_name(); ?>
				<?php else : ?>
					<a href="<?php echo admin_url( $menu_slug ); ?>">
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
				<?php
				foreach ( $integrations as $integration ) {
					/**
					 * If you have a settings page add filter and return your menu page slug.
					 *
					 * @param string $menu_slug
					 *
					 * @return string the menu slug to refer to.
					 *
					 * @see menu_page_url()
					 */
					$menu_slug = apply_filters(
						'unofficial_convertkit_integrations_admin_menu_slug_' . $integration->get_identifier(),
						''
					);

					$row( $integration, $menu_slug );
				}
				?>
			</tbody>
		</table>
	<?php
};
