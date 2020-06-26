<?php

namespace UnofficialConvertKit;

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
							<?php esc_html_e( 'ConvertKit forms', 'unofficial-convertkit' ); ?>
						</th>
						<td>
							<ul>
								<?php foreach ( $forms->forms as $form ) : ?>
									<li>
										<label>
											<input
													type="hidden"
													name="unofficial_convertkit_integrations_comment_form[form-ids][<?php echo $form->id; ?>]"
													value="0"
											>
											<input
													type="checkbox"
													name="unofficial_convertkit_integrations_comment_form[form-ids][<?php echo $form->id; ?>]"
													value="1"
													<?php if ( in_array( $form->id, $integration->get_options()['form-ids'], true ) ) : ?>
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
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>

	</div>
	<?php
};
