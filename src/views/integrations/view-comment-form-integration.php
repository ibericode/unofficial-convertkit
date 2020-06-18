<?php

namespace UnofficialConvertKit;

use UnofficialConvertKit\Integration\Integration;

/**
 * @param Integration $integration
 *
 * @internal
 */
return function( Integration $integration ) {
	?>
	<div class="wrap">
		<h1><?php echo $integration->get_name(); ?></h1>

		<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th>
							<?php esc_html_e( 'Enabled', 'unofficial-converkit' ); ?>
						</th>
						<td class="nowrap integration-toggles-wrap">
							<label>
								<input
										type="radio"
										name="unofficial_convertkit_comment_form[enabled]"
										value="0"
								>
							</label>
							<label>
								<input
										type="radio"
										name="unofficial_convertkit_comment_form[enabled]"
										value="1"
								>
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
