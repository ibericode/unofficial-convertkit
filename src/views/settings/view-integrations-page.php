<?php

namespace UnofficialConvertKit;

/**
 * @param array $integrations
 *
 * @internal
 */
return function( array $integrations ) {

	$row = function( string $i18n, string $description, bool $enabled, bool $installed ) {
		?>
		<tr>
			<td>
				<?php echo $i18n; ?>
			</td>
			<td class="desc">
				<?php echo $description; ?>
			</td>
			<td>
				<?php if ( $enabled ) : ?>
					Enabled
				<?php else : ?>
					Disabled
				<?php endif; ?>
			</td>
		</tr>
		<?php
	};

	call_user_func(
		require __DIR__ . '/view-settings-tabs.php',
		'integrations',
		function () use ( $integrations, $row ) {
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
					<?php $row( __( 'Custom', 'unofficial-convertkit' ), __( 'Custom integration', 'unofficial-convertkit' ), false, true ); ?>
				</tbody>
			</table>
			<?php
		}
	);
};
