<?php
/**
 * @param string $checkbox_label
 */
return function( string $checkbox_label ) {
	?>
		<label>
			<input type="checkbox" value="1">
			<?php echo $checkbox_label; ?>
		</label>
	<?php
};
