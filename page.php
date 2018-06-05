<?php
/**
 * The page template file
 */

get_header(); the_post(); ?>

<div class="container">
	<div class="row">

		<article class="<?php echo \ffblank\helper\front::get_grid_class(); ?>">

			<h1><?php the_title(); ?></h1>

			<?php the_content(); ?>
		</article>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer();