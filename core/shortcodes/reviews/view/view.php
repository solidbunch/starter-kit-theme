<?php
	$q_array = array(
		'post_type' => 'reviews',
		'post_status' => 'publish',
		'posts_per_page' => absint( $atts['posts_per_page'] ),
		'order' => $atts['order'],
		'orderby' => $atts['orderby'],
	);

	$items = new WP_Query( $q_array );

	if( $items->have_posts() ):
?>
<div class="shortcode-reviews">
	<div class="carousel">
		<?php while( $items->have_posts() ): $items->the_post(); ?>
			<div class="slide">
				<div class="item">

					<div class="desc">
						<?php esc_html_e('What Our Customers say:', 'fruitfulblanktextdomain'); ?>
					</div>

					<div class="text">
						<?php the_content(); ?>
					</div>

					<?php $rating = fw_get_db_post_option( get_the_ID(), 'rating' ); ?>
					<div class="rating" data-rating="<?php echo $rating; ?>"></div>

					<div class="reviews-num">
						<?php 
							$reviews_num = absint( fw_get_db_post_option( get_the_ID(), 'reviews_number' ) );
							$reviews = sprintf( _n( '%s review', '%s reviews', $reviews_num, 'fruitfulblanktextdomain' ), $reviews_num );
							printf( __( '%s star rating based on %s', 'fruitfulblanktextdomain'), $rating, $reviews );
						?>
					</div>

					<?php if( has_post_thumbnail() ): ?>
					<div class="logo">
						<?php the_post_thumbnail(); ?>
					</div>
					<?php endif; ?>

				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
</div>
<?php endif; 