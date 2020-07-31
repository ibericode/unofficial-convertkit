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
	array_unshift(
		$breadcrumbs,
		array(
			'url'        => admin_url( 'options-general.php?page=unofficial_convertkit' ),
			'breadcrumb' => 'Unofficial ConvertKit',
		)
	)
	?>
	<div id="unofficial-convertkit-admin" class="wrap">
		<nav aria-label="Breadcrumb" class="breadcrumbs">
			<ul>
				<li><?php _e( 'You are here:', 'unofficial-convertkit' ); ?></li>
			<?php $breadcrumb_count = count( $breadcrumbs ); ?>
			<?php foreach ( $breadcrumbs as $index => $breadcrumb ) : ?>
				<?php if ( $breadcrumb_count - 1 === $index ) : ?>
					<li><strong><?php echo $breadcrumb['breadcrumb']; ?></strong></li>
				<?php else : ?>
					<li>
						<a href="<?php echo $breadcrumb['url']; ?>">
							<?php echo $breadcrumb['breadcrumb']; ?>
						</a>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</nav>

		<?php $page(); ?>
	</div>
	<?php
};
