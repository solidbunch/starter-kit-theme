<?php
/**
 @array $data shortcode output data from controller
**/

	if( $data['items']->have_posts() ) {
?>
<div class="shortcode-postsimple<?php echo esc_attr( $data['css_class'] ); ?>" id="<?php echo esc_attr( $data['id'] ); ?>" >
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

					<div class="title">
						<?php the_title(); ?>
					</div>
					<div class="text">
						<?php the_content(); ?>
					</div>

				</div>
			</div>
	<?php } wp_reset_postdata(); ?>
	</div>
</div>
	<?php } 