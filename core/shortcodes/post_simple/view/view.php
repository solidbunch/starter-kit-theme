<?php
/**
 @array $data shortcode output data from controller
**/

	if( $data['items']->have_posts() ) {
		$max_num_pages = $data['items']->max_num_pages;
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
	<?php
		if( $max_num_pages > 1 && filter_var( $data['load_more'], FILTER_VALIDATE_BOOLEAN ) ):

	?>
		<div class="ajax-pagination">
			<a
				href="javascript:;"
				data-target-id="#container-<?php echo $data['el_id']; ?>" 
				data-next-page="2" 
				data-last-number="<?php echo $i; ?>" 
				data-max-pages="<?php echo esc_attr( $max_num_pages ); ?>" 
				data-action="fruitfulblankprefix_ajax_postsimple" 
				class="button load-more-posts">
					<?php echo wp_kses_post( $data['load_more_text'] ); ?>
			</a>
		</div>
	<?php endif; ?>
</div>
	<?php } 