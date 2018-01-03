<?php
	$q_array = array(
		'post_type' => 'dslc_testimonials',
		'post_status' => 'publish',
		'posts_per_page' => absint( $atts['posts_per_page'] ),
		'order' => $atts['order'],
		'orderby' => $atts['orderby'],
	);

	$items = new WP_Query( $q_array );

	if( $items->have_posts() ):
?>
<div class="shortcode-testimonials">
	<div class="carousel">
		<?php while( $items->have_posts() ): $items->the_post(); ?>
			<div class="slide">
				<div class="item">

					<?php if( has_post_thumbnail() ): ?>
					<div class="photo">
						<?php 
							echo fruitfulblankprefix_media::img( array(
								'url' => get_the_post_thumbnail_url( get_the_ID(), 'full'),
								'width' => 200,
								'height' => 200,
								'lazy' => false,
								'hd' => false,
								'atts' => array( 0 => 'alt=""')
							));
						?>
					</div>
					<?php endif; ?>

					<div class="text">
						<?php the_content(); ?>
					</div>

					<div class="details">
						<div class="name"><?php echo fw_get_db_post_option( get_the_ID(), 'name' ); ?></div>
						<div class="position"><?php echo fw_get_db_post_option( get_the_ID(), 'position' ); ?></div>
					</div>

				</div>
			</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>
</div>
<?php endif; 