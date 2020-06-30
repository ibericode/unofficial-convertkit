<?php

use UnofficialConvertKit\Integrations\Integration;

/**
 * @param Integration $integration
 * @param stdClass $forms
 */
return static function( Integration $integration, stdClass $forms ) {
	?>
	<div class="wrap">
		<h1><?php echo $integration->get_name(); ?></h1>
		<p><?php echo $integration->get_description(); ?></p>
		<?php

		/**
		 * Add a text above the form
		 *
		 * @param Integration $integration
		 */
		do_action(
			'unofficial_convertkit_integration_admin_integration_form_above_' . $integration->get_identifier(),
			$integration
		);
		?>

		<form method="post" action="<?php echo admin_url( 'options.php' ); ?>" >
			<?php settings_fields( 'unofficial_convertkit_integrations' ); ?>
			<input type="hidden" name="unofficial_convertkit_integrations[id]" value="<?php echo $integration->get_identifier(); ?>">

			<table class="form-table">
				<tbody>

					<?php if ( apply_filters( 'unofficial_convertkit_integrations_show_enabled', true, $integration ) ) : ?>
						<tr>
							<?php call_user_func( require __DIR__ . '/components/table/enable-row.php', $integration ); ?>
						</tr>
					<?php endif; ?>
					<tr>
						<?php
						call_user_func(
							require __DIR__ . '/components/table/convertkit-forms-row.php',
							$forms->form ?? array(),
							$integration
						);
						?>
					</tr>
					<tr>
						<?php call_user_func( require __DIR__ . '/components/table/checkbox-label-row.php', $integration ); ?>
					</tr>

					<?php
					/**
					 * Add the form
					 *
					 * @param Integration $integration
					 */
					do_action(
						'unofficial_convertkit_integrations_admin_integration_form_' . $integration->get_identifier(),
						$integration
					);
					?>
				<tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
};
