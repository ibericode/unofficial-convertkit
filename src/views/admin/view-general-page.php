<?php

use function UnofficialConvertKit\API\V3\is_connectable;
use function UnofficialConvertKit\obfuscate_string;

/**
 * Template used to register API credentials to connect to the API.
 *
 * @param array $settings {
 *      @type string $api_key
 *      @type string $api_secret
 * }
 *
 * @internal
 */
return static function( array $settings ) {
	?>
		<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
			<table class="form-table">
				<?php settings_fields( 'unofficial_convertkit' ); ?>
				<tr valign="top">
					<th scope="row">
						<?php esc_html_e( 'Status', 'unofficial-convertkit' ); ?>
					</th>
					<td>
						<?php if ( empty( $settings['api_key'] ) && empty( $settings['api_secret'] ) ) : ?>
							<span class="status neutral">
							<?php esc_html_e( 'NOT CONNECTED', 'unofficial-convertkit' ); ?>
						</span>
						<?php elseif ( is_connectable( $settings['api_key'], $settings['api_secret'] ) ) : ?>
							<span class="status positive">
							<?php esc_html_e( 'CONNECTED', 'unofficial-convertkit' ); ?>
						</span>
						<?php else : ?>
							<span class="status negative">
							<?php esc_html_e( 'NOT CONNECTED', 'unofficial-convertkit' ); ?>
						</span>
						<?php endif; ?>
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
								name="unofficial_convertkit_settings[api_key]"
								placeholder="<?php esc_html_e( 'Your ConvertKit API key', 'unofficial-convertkit' ); ?>"
							<?php if ( ! empty( $settings['api_key'] ) ) : ?>
								value="<?php echo obfuscate_string( $settings['api_key'] ); ?>"
							<?php endif; ?>
						/>
						<p class="description">
							<a href="https://app.convertkit.com/account/edit#api_key" target="_blank" >
								<?php esc_html_e( 'Get your ConvertKit API key.' ); ?>
							</a>
						</p>
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
								name="unofficial_convertkit_settings[api_secret]"
								placeholder="<?php esc_html_e( 'Your ConvertKit API secret' ); ?>"
							<?php if ( ! empty( $settings['api_secret'] ) ) : ?>
								value="<?php echo obfuscate_string( $settings['api_secret'] ); ?>"
							<?php endif; ?>
						/>
						<p class="description">
							<a href="https://app.convertkit.com/account/edit#show_api_secret" target="_blank" >
								<?php esc_html_e( 'Get your ConvertKit API secret.' ); ?>
							</a>
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	<?php
};
