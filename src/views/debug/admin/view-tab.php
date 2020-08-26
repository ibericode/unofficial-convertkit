<?php

use UnofficialConvertKit\Debug\Log;
use UnofficialConvertKit\Debug\Log_Reader;

/**
 * @param Log_Reader $log_reader
 */
return static function( Log_Reader $log_reader ) {
	?>
	<section class="widefat" id="debug">
		<h3><?php _e( 'Debug log', 'unofficial-convertkit' ); ?></h3>

		<div class="logs" style="overflow-y: scroll; color: white; background-color: #262626; width: 100%; min-height: 300px;">

			<?php $line = $log_reader->read(); ?>
			<?php if ( ! empty( $line ) ) : ?>
				<?php while ( is_string( $line ) ) : ?>
					<?php $log = ! empty( $line ) ? Log::from_format( $line ) : null; ?>
					<?php if ( $log instanceof Log ) : ?>
						<p class="log">
							<span class="time">[<?php echo $log->get_date()->format( 'Y-m-d H:i:s' ); ?>]</span>
							<span class="level"><?php echo $log->get_level_name(); ?>:</span>
							<span class="message"><?php echo $log->get_message(); ?></span>
						</p>
					<?php endif; ?>
					<?php $line = $log_reader->read(); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<p class="log empty">
					-- <?php _e( 'Nothing here. Which means there are no errors', 'unofficial-convertkit' ); ?>
				</p>
			<?php endif; ?>
		</div>
		<form method="post">
			<p>
				<input type="submit" class="button" value="<?php _e( 'Empty log', 'unofficial-convertkit' ); ?>">
			</p>
		</form>
	</section>
	<?php
};
