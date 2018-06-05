<?php get_header(); the_post(); ?>

<section id="content" class="container">
	<div class="row">
		<article class="<?php echo \ffblank\helper\front::get_grid_class(); ?>">

			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>

			<div class="clearfix"></div>

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
