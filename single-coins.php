<?php get_header(); ?>

<section id="content" class="container">
	<div class="row">
		<article class="<?php echo bvc_front::get_grid_class(); ?>">

			<?php the_post(); the_content(); ?>

			<div class="clearfix"></div>

		</article>

		<?php get_sidebar(); ?>

	</div>
</section>

<?php get_footer();