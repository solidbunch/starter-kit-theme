<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
} ?>

<div class="widget">
	<p class="fw-frontend-ext-sidebars-no-widget">
		<?php printf( esc_html__( 'The sidebar (%s) you added has no widgets. Please add some from the ', 'starter-kit' ), $sidebar_id ); ?>
		<a href="<?php echo admin_url( 'widgets.php' ) ?>"
		   target="_blank"><?php esc_html_e( 'Widgets Page', 'starter-kit' ); ?></a>
	</p>
</div>
