<?php get_header(); ?>

<section id="content" class="container">
	<div class="row">
		<article class="<?php echo fruitfulblankprefix_front::get_grid_class(); ?>">

			<h1><?php the_title(); ?></h1>

			<?php get_template_part( 'template-parts/post-data'); ?>

			<?php if( has_post_thumbnail() ): ?>
				<div class="post-thumb">
					<?php 
						echo fruitfulblankprefix_media::img( array(
							'url' => get_the_post_thumbnail_url( get_the_ID(), 'full'),
							'width' => 1140,
							'height' => 600,
							'lazy' => false,
							'hd' => false,
							'atts' => array( 0 => 'alt=""')
						));
					?>
				</div>
			<?php endif; ?>

			<?php the_post(); the_content(); ?>

			<div class="clearfix"></div>

			<?php get_template_part( 'template-parts/related-posts'); ?>

			<!--
				Comments
			-->
			
			<?php if( !post_password_required() ): ?>
				<div id="comments-block">
					<?php comments_template( '', true ); ?>
				</div>
			<?php endif; ?>

		</article>

		<?php get_sidebar(); ?>

	</div>
</section>

<?php get_footer();