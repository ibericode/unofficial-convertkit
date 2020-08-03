<?php

use UnofficialConvertKit\Integrations\Integration;

/**
 * The convert kit forms to use for the integration
 *
 * @param stdClass[] $forms
 * @param Integration $integration
 *
 * @internal
 */
return static function( array $forms, Integration $integration ) {
	?>
	<th>
		<?php esc_html_e( 'ConvertKit forms', 'unofficial-convertkit' ); ?>
	</th>
	<td>
		<ul>
			<?php foreach ( $forms as $form ) : ?>
				<li>
					<label>
						<input
							type="checkbox"
							name="<?php printf( 'unofficial_convertkit_integrations[%s][form-ids][]', $integration->get_identifier() ); ?>"
							value="<?php echo $form->id; ?>"
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
			<?php esc_html_e( 'Select ConvertKit form(s) to which people who tick the checkbox should be subscribed.', 'unofficial-convertkit' ); ?>
		</p>
	</td>
	<?php
};
