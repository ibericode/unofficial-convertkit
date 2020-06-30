<?php

use stdClass;
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

			<?php

			/**
			 * Add the form
			 *
			 * @param Integration $integration
			 * @param stdClass $forms
			 */
			do_action(
				'unofficial_convertkit_integrations_admin_integration_form_' . $integration->get_identifier(),
				$integration,
				$forms
			);
			?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
};
