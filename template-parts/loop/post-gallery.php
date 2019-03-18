<article <?php post_class(); ?>>

	<?php
		$gallery = get_post_gallery_images( get_the_ID() );
		if( !empty( $gallery ) ):
	?>
	<div class="thumb carousel">
		<?php foreach( $gallery as $image ): ?>
			<img src="<?php echo str_replace( '-150x150.', '.', $image ); ?>" alt="<?php echo esc_attr( get_the_title()); ?>">
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

	<?php get_template_part( '/template-parts/loop/post-data' ); ?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e( 'Read more', 'starter-kit' ); ?></a>

</article>
