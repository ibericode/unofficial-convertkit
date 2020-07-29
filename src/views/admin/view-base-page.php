<?php
/**
 * Base view to use for every settings page in the plugin.
 *
 * @param array $breadcrumbs {
 *      @type string $url the url of the breadcrumb
 *      @type string $breadcrumb translated i18n page title of the breadcrumb
 * }
 *
 * @param callable $page
 *
 * @internal
 */
return static function( array $breadcrumbs, callable $page ) {
	?>
	<div id="unofficial-convertkit-admin" class="wrap">
		<div style="padding: 1rem 0;">

			<span><?php _e( 'You are here:', 'unofficial-convertkit' ); ?></span>
			<?php $breadcrumb_count = count( $breadcrumbs ); ?>
			<?php foreach ( $breadcrumbs as $index => $breadcrumb ) : ?>
				<?php if ( $breadcrumb_count - 1 === $index ) : ?>
					<span><strong><?php echo $breadcrumb['breadcrumb']; ?></strong></span>
				<?php else : ?>
					<span><a href="<?php echo $breadcrumb['url']; ?>"><?php echo $breadcrumb['breadcrumb']; ?></a></span>
				<?php endif; ?>
			<?php endforeach; ?>

		</div>

		<?php $page(); ?>
	</div>
	<?php
};
