<?php

namespace UnofficialConvertKit\Integrations\Admin;

use stdClass;
use UnofficialConvertKit\Integrations\Integration;

/**
 * @param Integration $integration
 *
 * @param stdClass $forms
 *
 * @internal
 */
return function( Integration $integration, stdClass $forms ) {
	$options = $integration->get_options();
	?>
	<div class="wrap">
		<h1><?php echo $integration->get_name(); ?></h1>
		<p><?php esc_html_e( 'Subscribes people from your WordPress comment form.', 'unofficial-convertkit' ); ?></p>
		<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
			<?php settings_fields( 'unofficial_convertkit_integrations_comment_form' ); ?>
			<table class="form-table">
				<tbody>
					<tr>
						<th>
							<?php esc_html_e( 'Enabled', 'unofficial-convertkit' ); ?>
						</th>
						<td class="nowrap integration-toggles-wrap">
							<label>
								<input
										type="radio"
										name="unofficial_convertkit_integrations_comment_form[enabled]"
										value="1"
										<?php echo $integration->is_active() ? 'checked' : null; ?>
								>
								<?php esc_html_e( 'Yes', 'unofficial-convertkit' ); ?>
							</label>
							&nbsp;
							<label>
								<input
										type="radio"
										name="unofficial_convertkit_integrations_comment_form[enabled]"
										value="0"
										<?php echo $integration->is_active() ? null : 'checked'; ?>
								>
								<?php esc_html_e( 'No', 'unofficial-convertkit' ); ?>
							</label>
							<p class="help">
								<?php esc_html_e( 'Enable the Comment Form integration? This will add a sign-up checkbox to the form.', 'unofficial-convertkit' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th>
							<?php esc_html_e( 'Implicit?', 'unofficial-convertkit' ); ?>
						</th>
						<td class="nowrap">
							<label>
								<input
										type="radio"
										value="1"
										name="unofficial_convertkit_integrations_comment_form[implicit]"
										<?php if ( $options['implicit'] ) : ?>
											checked
										<?php endif; ?>
								>
								<?php esc_html_e( 'Yes', 'unofficial-convertkit' ); ?>
							</label>
							<label>
								<input
										type="radio"
										value="0"
										name="unofficial_convertkit_integrations_comment_form[implicit]"
										<?php if ( ! $options['implicit'] ) : ?>
											checked
										<?php endif; ?>
								>
								<?php esc_html_e( 'No', 'unofficial-convertkit' ); ?>
								<em>(<?php esc_html_e( 'Recommended', 'unofficial-convertkit' ); ?>)</em>
							</label>
						</td>
					</tr>
					<tr>
						<th>
							<?php esc_html_e( 'ConvertKit forms', 'unofficial-convertkit' ); ?>
						</th>
						<td>
							<ul>
								<?php foreach ( $forms->forms as $form ) : ?>
									<li>
										<label>
											<input
													type="checkbox"
													name="unofficial_convertkit_integrations_comment_form[form-ids][]"
													value="<?php echo $form->id; ?>"
													<?php if ( in_array( $form->id, $options['form-ids'], true ) ) : ?>
														checked
													<?php endif; ?>
											>

											<?php echo $form->name; ?>
										</label>
									</li>
								<?php endforeach; ?>
							</ul>

							<p class="help">
								<?php esc_html_e( 'Select form (s) to which people who check the checkbox should be subscribed.', 'unofficial-convertkit' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th>
							<label for="unofficial-convertkit-checkbox-label">
								<?php esc_html_e( 'Checkbox label text', 'unofficial-convertkit' ); ?>
							</label>
						</th>
						<td>
							<input
									type="text"
									class="widefat"
									id="unofficial-convertkit-checkbox-label"
									name="unofficial_convertkit_integrations_comment_form[checkbox-label]"
									<?php if ( ! empty( $options['checkbox-label'] ) ) : ?>
										value="<?php echo $options['checkbox-label']; ?>"
									<?php else : ?>
										value="<?php _e( 'Sign me up for the newsletter!', 'unofficial-convertkit' ); ?>"
									<?php endif; ?>
							>
						</td>
					</tr>
					<tr>
						<th>
							<?php esc_html_e( 'Load some default CSS?', 'unofficial-converkit' ); ?>
						</th>
						<td class="nowrap">
							<label>
								<input
										type="radio"
										name="unofficial_convertkit_integrations_comment_form[load-css]"
										value="1"
										<?php if ( $options['load-css'] ) : ?>
											checked
										<?php endif; ?>
								>
								<?php esc_html_e( 'Yes', 'unofficial-convertkit' ); ?>
							</label>
							<label>
								<input
										type="radio"
										name="unofficial_convertkit_integrations_comment_form[load-css]"
										value="0"
										<?php if ( ! $options['load-css'] ) : ?>
											checked
										<?php endif; ?>
								>
								<?php esc_html_e( 'No', 'unofficial-convertkit' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>

	</div>
	<?php
};
