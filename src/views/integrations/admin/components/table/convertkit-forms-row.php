<?php

use UnofficialConvertKit\Integrations\Integration;

/**
 * @param stdClass[] $forms
 * @param int[] $form_ids
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
			<?php esc_html_e( 'Select form (s) to which people who check the checkbox should be subscribed.', 'unofficial-convertkit' ); ?>
		</p>
	</td>
	<?php
};
