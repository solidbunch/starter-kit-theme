<article <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ): ?>
		<div class="thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'full'); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php get_template_part( '/template-parts/loop/post-data' ); ?>

	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<div class="excerpt">
		<?php the_content(); ?>
	</div>

</article>
