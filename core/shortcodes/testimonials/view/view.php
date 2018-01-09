<?php
/**
 @array $data shortcode output data from controller
**/

	if( $data['items']->have_posts() ) {
?>
<div class="shortcode-testimonials">
	<div class="carousel">
		<?php while( $data['items']->have_posts() ) { $data['items']->the_post(); ?>
			<div class="slide">
				<div class="item">

					<?php if( has_post_thumbnail() ){ ?>
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
					<?php } ?>

					<div class="text">
						<?php the_content(); ?>
					</div>

					<div class="details">
						<div class="name"><?php echo fw_get_db_post_option( get_the_ID(), 'name' ); ?></div>
						<div class="position"><?php echo fw_get_db_post_option( get_the_ID(), 'position' ); ?></div>
					</div>

				</div>
			</div>
	<?php } wp_reset_postdata(); ?>
	</div>
</div>
	<?php } 