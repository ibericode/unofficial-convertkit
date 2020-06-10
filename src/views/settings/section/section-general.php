<?php
/**
 * Template used to register API credentials to connect to the user.
 *
 * @internal
 */
return function() {
	?>
	<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
		<table class="form-table">
			<?php settings_fields( 'unofficial_convertkit_settings' ); ?>
			<tr valign="top">
				<th scope="row">
					<?php esc_html_e( 'Status', 'unofficial-convertkit' ); ?>
				</th>
				<td>
					<span class="status positive">
						<?php esc_html_e( 'CONNECTED', 'unofficial-convertkit' ); ?>
					</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="api-key">
						<?php esc_html_e( 'API Key', 'unofficial-convertkit' ); ?>
					</label>
				</th>
				<td>
					<input
							required
							type="text"
							class="widefat"
							id="api-key"
							name="unofficial_convertkit[api_key]"
							placeholder="<?php esc_html_e( 'Your ConvertKit API key', 'unofficial-convertkit' ); ?>"
					/>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="api-secret">
						<?php esc_html_e( 'API Secret', 'unofficial-convertkit' ); ?>
					</label>
				</th>
				<td>
					<input
							required
							type="text"
							class="widefat"
							id="api-secret"
							name="unofficial_convertkit[api_secret]"
							placeholder="<?php esc_html_e( 'Your ConvertKit API secret' ); ?>"
					/>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
	<?php
}
?>
