<?php

use UnofficialConvertKit\Debug\Log;
use UnofficialConvertKit\Debug\Log_File;

/**
 * @param Log[] $logs
 */
return static function( Log_File $log_file ) {
	?>
	<section class="widefat">
		<h3><?php _e( 'Debug log', 'unofficial-convertkit' ); ?></h3>
		<form method="post">
			<label>
				<textarea readonly style="overflow-y: scroll; color: white; background-color: #262626; width: 100%;" rows="8">
					<?php while ( $log_file->valid() ) : ?>
						<?php $log = $log_file->current(); ?>
						<?php if ( $log instanceof Log ) : ?>
							<span class="time"><?php echo $log->get_date()->format( 'Y-m-d H:i:s' ); ?></span>
							<span class="level"><?php echo $log->get_level(); ?></span>
							<span class="message"><?php echo $log->get_message(); ?></span>
						<?php endif; ?>
						<?php $log_file->next(); ?>
					<?php endwhile; ?>
				</textarea>
			</label>
			<p>
				<input type="submit" class="button" value="<?php _e( 'Empty log', 'unofficial-convertkit' ); ?>">
			</p>
		</form>
	</section>
	<?php
};
