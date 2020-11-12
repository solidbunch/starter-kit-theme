<article <?php post_class(); ?>>

	<?php
		$content = apply_filters( 'the_content', get_the_content() );
		$embeds = get_media_embedded_in_content( $content );
		if( isset( $embeds[0] ) ):
	?>
	<div class="thumb">
		<?php echo apply_filters( 'the_content', $embeds[0] ); ?>
	</div>
	<?php endif; ?>

	<?php get_template_part( '/template-parts/loop/post-data' ); ?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e( 'Read more', 'starter-kit' ); ?></a>

</article>
