<article <?php post_class(); ?>>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php esc_html_e( 'Shop it', 'starter-kit' ); ?></a>

</article>
