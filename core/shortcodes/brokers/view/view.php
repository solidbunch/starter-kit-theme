<?php
	$q_array = array(
		'post_type' => 'brokers',
		'post_status' => 'publish',
		'posts_per_page' => absint( $atts['posts_per_page'] ),
		'order' => $atts['order'],
		'orderby' => $atts['orderby'],
	);

	$items = new WP_Query( $q_array );

	if( $items->have_posts() ):
?>
<div class="shortcode-brokers">
	<div class="carousel">
		<?php while( $items->have_posts() ): $items->the_post(); ?>
			<div class="slide">
				<div class="item">
					<?php if( has_post_thumbnail() ): ?>
					<div class="thumb">
						<?php the_post_thumbnail( array( 380, 380 )); ?>
					</div>
					<?php endif; ?>

					<div class="text">

						<div class="title">
							<h4><?php the_title(); ?></h4>
							<div class="position"><?php echo fw_get_db_post_option( get_the_ID(), 'position' ); ?></div>
						</div>

						<div class="details">
							<div class="email"><i class="fa fa-envelope"></i> <?php echo fw_get_db_post_option( get_the_ID(), 'email' ); ?></div>
							<div class="phone"><i class="fa fa-phone-square"></i> <?php echo fw_get_db_post_option( get_the_ID(), 'phone' ); ?></div>
						</div>

						<a href="mailto:<?php echo fw_get_db_post_option( get_the_ID(), 'email' ); ?>" class="button"><?php esc_html_e( 'GET IN TOUCH', 'bvc'); ?></a>

					</div>

				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
</div>
<?php endif; 