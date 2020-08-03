<?php

use UnofficialConvertKit\Integrations\Admin\Integrations_Controller;
use UnofficialConvertKit\Integrations\Integration;

/**
 * View for
 *
 * @param Integration[] $integrations
 *
 * @internal
 *
 * @see Integrations_Controller::index()
 */
return static function( array $integrations ) {

	$row = static function( Integration $integration, string $menu_slug ) {
		?>
		<?php if ( $integration->is_available() ) : ?>
			<tr>
		<?php else : ?>
			<tr style="opacity: 0.4">
		<?php endif; ?>
			<td>
				<?php if ( ! empty( $menu_slug ) && $integration->is_available() ) : ?>
					<a href="<?php echo admin_url( $menu_slug ); ?>">
						<strong><?php echo $integration->get_name(); ?></strong>
					</a>
				<?php else : ?>
					<?php echo $integration->get_name(); ?>
				<?php endif; ?>
			</td>
			<td class="desc">
				<?php echo $integration->get_description(); ?>
			</td>
			<td>
				<?php if ( ! $integration->is_available() ) : ?>
					<span style="color: red">
						<?php esc_html_e( 'Not installed', 'unofficial-convertkit' ); ?>
					</span>
				<?php elseif ( $integration->is_active() ) : ?>
					<span style="color: #32cd32">
						<?php esc_html_e( 'Active', 'unofficial-convertkit' ); ?>
					</span>
				<?php else : ?>
					<?php esc_html_e( 'Inactive', 'unofficial-convertkit' ); ?>
				<?php endif; ?>
			</td>
		</tr>
		<?php
	};

	?>
		<h3><?php esc_html_e( 'Integrations', 'unofficial-convertkit' ); ?></h3>
		<p>
			<?php esc_html_e( 'The table below shows all available integrations. Click on the name of an integration to edit all settings specific to that integration.', 'unofficial-convertkit' ); ?>
		</p>
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
