<article <?php post_class(); ?>>

	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<div class="excerpt">
		<?php the_content(); ?>
	</div>

</article>
