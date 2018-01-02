	<?php
		$disable_particles_footer = is_page() ? filter_var( fw_get_db_post_option( get_the_ID(), 'disable_particles_footer' ), FILTER_VALIDATE_BOOLEAN ) : false;
		if( is_home() || is_single() || is_404() ) {
			$disable_particles_footer = true;
		}
		if( ! $disable_particles_footer ):
	?>
	<div class="clearfix"></div>
	<footer id="page-footer">
		<div class="particles">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2><?php echo fw_get_db_settings_option( 'footer_particles_text'); ?></h2>
						<?php
							$button_page_id = fw_get_db_settings_option( 'footer_particles_button_link');
							$button_link = isset( $button_page_id[0] ) && is_numeric( $button_page_id[0] ) ? get_permalink( $button_page_id[0] ) : '';
							if( $button_link <> '' ):
						?>
						<a href="<?php echo esc_attr( $button_link ); ?>" class="button style-white"><?php echo fw_get_db_settings_option( 'footer_particles_button_text'); ?> <i class="fa fa-angle-right"></i></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<?php endif; ?>

	<div class="clearfix"></div>
	<footer id="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-3">

					<?php dynamic_sidebar( 'footer-1' ); ?>

				</div>
				<div class="col-md-3">

					<?php dynamic_sidebar( 'footer-2' ); ?>

				</div>
				<div class="col-md-3">

					<?php dynamic_sidebar( 'footer-3' ); ?>

				</div>
				<div class="col-md-3">

					<?php dynamic_sidebar( 'footer-4' ); ?>

				</div>
			</div>
		</div>
	</footer>

	<footer id="bottom-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p><?php echo fw_get_db_settings_option( 'bottom_bar_text'); ?></p>
				</div>
			</div>
		</div>
	</footer>
	
	<?php wp_footer(); ?>
</body>
</html>