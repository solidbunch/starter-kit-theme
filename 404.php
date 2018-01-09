<?php get_header(); ?>

<section id="content" class="container">
	<div class="row">
		<article class="<?php echo fruitfulblankprefix_front::get_grid_class(); ?>">

			<h2 class="align-center">
				<?php esc_html_e( 'Unfortunately, we can not find requested page.', 'fruitfulblanktextdomain'); ?>
				<br/>
				<?php esc_html_e( 'Try to find something else using a form below.', 'fruitfulblanktextdomain'); ?>
			</h2>

			<?php get_search_form(); ?>

		</article>

	</div>
</section>

<?php get_footer();