<?php

	global $fruitfulblankprefix_theme;
	$similar_posts = $fruitfulblankprefix_theme->model->post->get_related_posts( get_the_ID(), 3, 'category', true );

	if( $similar_posts != false && $similar_posts->have_posts() ):
?>

<!-- 
Related posts
-->
<div id="related-posts">

	<h4 class="block-title"><?php esc_html_e( 'Related', 'fruitfulblanktextdomain'); ?></h4>

	<div class="row">
		<?php while ( $similar_posts->have_posts() ): $similar_posts->the_post(); ?>
			<div class="item col-md-4">
				
			<?php if( has_post_thumbnail() ): ?>
			<a class="thumb" href="<?php the_permalink(); ?>">
				<?php
					echo fruitfulblankprefix_media::img( array(
						'width' => 370,
						'height' => 250,
						'url' => wp_get_attachment_url( get_post_thumbnail_id( get_the_ID()) ),
						'lazy' => false
					));
				?>
			</a>
			<?php endif; ?>

			<div class="post-data">
				<span class="date">
					<?php the_time( 'F d, Y' ); ?>
				</span> <span class="separator">|</span> 
				<span class="author">
					<?php esc_html_e( 'By', 'fruitfulblanktextdomain'); ?> <?php the_author_link(); ?>
				</span>
			</div>

			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

			<div class="excerpt">
				<?php the_excerpt(); ?>
			</div>

			<a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e( 'READ MORE', 'fruitfulblanktextdomain'); ?></a>

		</div>
		<?php endwhile; wp_reset_postdata(); ?>
	</div>

</div>

<?php endif;